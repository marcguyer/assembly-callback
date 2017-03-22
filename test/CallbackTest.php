<?php

namespace AssemblyTest\Callback;

use Assembly\Callback\Callback;
use PHPUnit\Framework\TestCase;

/**
 * @group      Assembly_Callback
 */
class CallbackTest extends TestCase
{

    /**
     * Test that parsing and composing a valid Callback returns the same Callback
     *
     * @param        string $callbackString
     * @dataProvider validCallbackStringProvider
     */
    public function testParseComposeCallback($callbackString)
    {
        $callbackString = $callbackString();
        $callback = new Callback($callbackString);
        $this->assertEquals($callbackString, $callback->toString());
    }

    /**
     * Accessor Tests
     */

    /**
     * Validation tests
     */

    /**
     * Test that validation completes
     *
     * @param string $callbackString
     * @dataProvider validCallbackStringProvider
     */
    public function testValidateRawCallbackThrowsException($callbackString)
    {
        $callbackString = $callbackString();
        $callback = new Callback($callbackString);
        // should throw exception because this is a raw callback
        // that doesn't know how to validate
        $this->setExpectedException('\RuntimeException');
        $callback->validate();
    }

    /**
     * Other tests
     */

    /**
     * Test that the copy constructor works
     *
     * @dataProvider validCallbackStringProvider
     */
    public function testConstructorCopyExistingObject($callbackString)
    {
        $callbackString = $callbackString();
        $callback = new Callback($callbackString);
        $callback2 = new Callback($callback);

        $this->assertEquals($callback, $callback2);
    }

    /**
     * Data Providers
     */

    /**
     * Data provider for valid Callbacks, not necessarily complete
     *
     * @return array
     */
    public function validCallbackStringProvider()
    {
        return array(
            'items' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/items.json'
                ));
            }),
            'users' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/users.json'
                ));
            }),
            'companies' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/companies.json'
                ));
            }),
            'accounts' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/accounts.json'
                ));
            }),
            'transactions' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/transactions.json'
                ));
            }),
            'batch_transactions' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/batch_transactions.json'
                ));
            }),
        );
    }

}
