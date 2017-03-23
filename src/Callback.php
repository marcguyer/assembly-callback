<?php

namespace Assembly\Callback;

use Zend\Json\Json;

/**
 * Generic Callback handler
 */
class Callback implements CallbackInterface
{

    /**
     * Callback type
     *
     * @var string
     */
    protected $type;

    /**
     * Callback object
     *
     * @var stdClass
     */
    protected $object;

    /**
     * Callback validation state
     *
     * @var bool
     */
    protected $validated = false;

    /**
     * Create a new Callback object
     *
     * @param  Callback|string|null $callback
     * @throws \InvalidArgumentException
     */
    public function __construct($callback = null)
    {
        if (is_string($callback)) {
            $this->parse($callback);
        } elseif ($callback instanceof CallbackInterface) {
            // Copy constructor
            $this->setType($callback->getType());
            $this->setObject($callback->getObject());
        } elseif ($callback !== null) {
            throw new \InvalidArgumentException(sprintf(
                'Expecting a string or a Callback object, received "%s"',
                (is_object($callback) ?
                    get_class($callback) :
                    gettype($callback))
            ));
        }
    }

    /**
     * Magic method to proxy to callback object properties
     *
     * @param string $property
     * @return string The value of the property
     */
    public function __get($property) {
        if (isset($this->getObject()->$property)) {
            return $this->getObject()->$property;
        }
        return parent::__get($property);
    }

    /**
     * Reset Callback parts
     */
    protected function reset()
    {
        $this->setType(null);
        $this->setObject(null);
    }

    /**
     * Parse a Callback string
     *
     * @param  string $callbackString
     * @throws \InvalidArgumentException
     * @return Callback
     */
    public function parse($callbackString)
    {
        $this->reset();

        if (null === $obj = Json::decode($callbackString)) {
            throw new \InvalidArgumentException(
                'String is expected to be json but decode failed'
            );
        }

        // the root node of the json object is the object type
        $properties = get_object_vars($obj);

        if (1 != $count = count($properties)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected 1 object property but found %s',
                    $count
                )
            );
        }

        $type = key($properties);

        $this->setType($type);
        $this->setObject($obj->$type);

        return $this;
    }

    /**
     * Validate by requesting the same object from the API
     *
     * If valid, the object data is replaced with that received
     * from the API.
     *
     * If invalid, the PromisePay sdk throws an exception
     *
     * @return Callback
     */
    public function validate()
    {
        // if already validated, avoid doing it again
        if ($this->validated) {
            return $this;
        }

        $this->setObject($this->getRemoteObject());

        $this->validated = true;

        return $this;

    }

    /**
     * Get the same object from the API
     *
     * @throws \RuntimeException if this method is not extended
     * @return stdClass
     */
    protected function getRemoteObject()
    {
        throw new \RuntimeException(
            'The ' . __METHOD__ .
                ' method must be implemented in the type subclass'
        );
    }

    /**
     * Get the type of the Callback
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the Object
     *
     * @return stdClass|null
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set the type
     *
     * @param  string $type
     * @return Callback
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set the object
     *
     * @param  stdClass $object
     * @return Callback
     */
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Compose the Callback into a string
     *
     * @return string
     */
    public function toString()
    {
        return $this->toJson();
    }

    /**
     * Compose the Callback into a JSON string
     *
     * Proxies to Zend\Json\Json::encode()
     *
     * @param  bool $cycleCheck Optional; whether or not to check for object recursion; off by default
     * @param  array $options Additional options used during encoding
     * @return string
     */
    public function toJson($cycleCheck = false, $options = array())
    {
        $native = (object) array(
            $this->type => $this->object
        );
        return Json::encode($native);
    }

    /**
     * Magic method to convert the Callback to a string
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->toString();
        } catch (\Exception $e) {
            return '';
        }
    }

}
