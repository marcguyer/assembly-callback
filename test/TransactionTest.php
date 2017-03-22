<?php

namespace AssemblyTest\Callback;

use Assembly\Callback\Transaction;
use PHPUnit\Framework\TestCase;

/**
 * @group      Assembly_Callback
 */
class TransactionTest extends TestCase
{

    /**
     * Test that validation completes
     *
     * @param string $callbackString
     * @dataProvider validCallbackStringProvider
     */
    public function testValidate($callbackString)
    {
        $callbackString = $callbackString();
        $callback = new Transaction($callbackString);
        $this->setExpectedException('\RuntimeException');
        $callback->validate();
    }

    /**
     * Data Providers
     */

    /**
     * Data provider for valid Callbacks
     *
     * @return array
     */
    public function validCallbackStringProvider()
    {
        return array(
            'transactions' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/transactions.json'
                ));
            }),
        );
    }

}
