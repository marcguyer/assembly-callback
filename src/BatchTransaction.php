<?php

namespace Assembly\Callback;

use PromisePay\PromisePay;

/**
 * BatchTransaction callback type
 */
class BatchTransaction extends Callback
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
        return PromisePay::BatchTransactions()->show($this->getObject()->id);
    }

}
