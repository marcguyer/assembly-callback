<?php

namespace AssemblyTest\Callback;

use Assembly\Callback\Account;
use PHPUnit\Framework\TestCase;

/**
 * @group      Assembly_Callback
 */
class AccountTest extends TestCase
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
        $callback = new Account($callbackString);
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
            'accounts' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/accounts.json'
                ));
            }),
        );
    }

}
