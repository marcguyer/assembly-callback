<?php

namespace Assembly\Callback;

/**
 * Callback Factory Class
 *
 * The Callback factory can be used to generate Callback objects from strings, using a
 * different Callback subclass depending on the input Callback type. New type-specific
 * classes can be registered using the registerType() method.
 *
 * Note that this class contains only static methods and should not be
 * instantiated
 */
abstract class CallbackFactory
{
    /**
     * Registered type-specific classes
     *
     * @var array
     */
    protected static $typeClasses = array(
        'message' => 'Assembly\Callback\Message',
        'items' => 'Assembly\Callback\Item',
        'users' => 'Assembly\Callback\User',
        'companies' => 'Assembly\Callback\Company',
        'accounts' => 'Assembly\Callback\Account',
        'transactions' => 'Assembly\Callback\Transaction',
        'batch_transactions' => 'Assembly\Callback\BatchTransaction',
    );

    /**
     * Register a type-specific class to be used
     *
     * @param string $type
     * @param string $class
     */
    public static function registerType($type, $class)
    {
        $type = strtolower($type);
        static::$typeClasses[$type] = $class;
    }

    /**
     * Unregister a type
     *
     * @param string $type
     */
    public static function unregisterType($type)
    {
        $type = strtolower($type);
        if (isset(static::$typeClasses[$type])) {
            unset(static::$typeClasses[$type]);
        }
    }

    /**
     * Get the class name for a registered type
     *
     * If provided type is not registered, will return NULL
     *
     * @param  string $type
     * @return string|null
     */
    public static function getRegisteredTypeClass($type)
    {
        if (isset(static::$typeClasses[$type])) {
            return static::$typeClasses[$type];
        } else {
            return null;
        }
    }

    /**
     * Create a Callback from a string
     *
     * @param  string $callbackString
     * @throws InvalidArgumentException
     * @return \Assembly\Callback\Callback
     */
    public static function factory($callbackString)
    {
        if (!is_string($callbackString)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expecting a string, received "%s"',
                    (is_object($callbackString) ?
                        get_class($callbackString) :
                        gettype($callbackString))
                )
            );
        }

        $callback = new Callback($callbackString);
        $type = strtolower($callback->getType());

        if (!isset(static::$typeClasses[$type])) {
            throw new \InvalidArgumentException(sprintf(
                    'no class registered for type "%s"',
                    $type
                ));
        }

        $class = static::$typeClasses[$type];
        $callback = new $class($callback);
        if (! $callback instanceof CallbackInterface) {
            throw new \InvalidArgumentException(sprintf(
                'class "%s" registered for type "%s" does not implement ' .
                    'Assembly\Callback\CallbackInterface',
                $class,
                $type
            ));
        }

        return $callback;
    }
}
