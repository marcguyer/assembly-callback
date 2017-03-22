<?php

namespace AssemblyTest\Callback;

use Assembly\Callback\Item;
use PHPUnit\Framework\TestCase;

/**
 * @group      Assembly_Callback
 */
class ItemTest extends TestCase
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
        $callback = new Item($callbackString);
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
            'items' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/items.json'
                ));
            }),
        );
    }

}
