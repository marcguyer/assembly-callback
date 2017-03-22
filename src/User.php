<?php

namespace Assembly\Callback;

/**
 * User callback type
 */
class User extends Callback
{

    /**
     * Get the same object from the API
     *
     * @throws \RuntimeException if the PromisePay sdk is unavailable
     * @return stdClass
     */
    protected function getRemoteObject()
    {
        if (!class_exists('PromisePay')) {
            throw new \RuntimeException(
                'The PromisePay SDK is required for this method'
            );
        }
        return PromisePay::User()->get($this->getObject()->id);
    }

}
