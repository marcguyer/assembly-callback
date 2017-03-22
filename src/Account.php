<?php

namespace Assembly\Callback;

/**
 * Account callback type
 */
class Account extends Callback
{

    public static $accountTypeIdMap = array(
        '9200' => 'CardAccount'
    );

    /**
     * Get the same object from the API
     *
     * @throws \RuntimeException if the PromisePay sdk is unavailable
     * @throws \OutOfBoundsException if account_type_id is missing
     * @throws \UnexpectedValueException if the account_type_id isn't recognized
     * @return stdClass
     */
    protected function getRemoteObject()
    {
        // this will need to know which account type we're dealing with
        if (!class_exists('PromisePay')) {
            throw new \RuntimeException(
                'The PromisePay SDK is required for this method'
            );
        }

        if (!isset($this->account_type_id)) {
            throw new \OutOfBoundsException(
                'Missing account_type_id'
            );
        }

        if (!isset(self::$accountTypeIdMap[$this->account_type_id])) {
            throw new \UnexpectedValueException(
                'The value of account_type_id (' .
                    $this->account_type_id . ') is not recognized'
            );
        }

        $method = self::$accountTypeIdMap[$this->account_type_id];
        return PromisePay::$method()->get($this->getObject()->uuid);
    }

}
