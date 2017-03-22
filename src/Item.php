<?php

namespace Assembly\Callback;

use PromisePay\PromisePay;

/**
 * Item callback type
 */
class Item extends Callback
{

    /**
     * Get the same object from the API
     *
     * @throws \RuntimeException if the PromisePay sdk is unavailable
     * @return stdClass
     */
    protected function getRemoteObject()
    {
        if (!class_exists('\PromisePay\PromisePay')) {
            throw new \RuntimeException(
                'The PromisePay SDK is required for this method'
            );
        }
        return PromisePay::Item()->get($this->getObject()->id);
    }

}
