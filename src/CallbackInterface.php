<?php

namespace Assembly\Callback;

/**
 * Interface defining a Callback
 */
interface CallbackInterface
{
    /**
     * Create a new Callback object
     *
     * @param  Callback|string|null $callback
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($callback = null);

    /**
     * Parse a Callback string
     *
     * @param  string $callback
     * @return Callback
     */
    public function parse($callback);

    /**
     * Validate by requesting the same object from the API
     *
     * @return Callback
     */
    public function validate();

    /**
     * Compose the Callback into a string
     *
     * @return string
     */
    public function toString();

    /**
     * Compose the Callback into a JSON string
     *
     * @return string
     */
    public function toJson();

    /**
     * Get the type of Callback
     *
     * @return string|null
     */
    public function getType();

    /**
     * Get the callback object
     *
     * @return stdClass|null
     */
    public function getObject();

    /**
     * Set the Callback type
     *
     * @param  string $type
     * @return Callback
     */
    public function setType($type);

    /**
     * Set the Callback object
     *
     * @param  stdClass|null $object
     * @return Callback
     */
    public function setObject($object);

    /**
     * Magic method to convert the Callback to a string
     *
     * @return string
     */
    public function __toString();
}
