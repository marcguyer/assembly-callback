<?php

namespace AssemblyTest\Callback;

use Assembly\Callback\Company;
use PHPUnit\Framework\TestCase;

/**
 * @group      Assembly_Callback
 */
class CompanyTest extends TestCase
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
        $callback = new Company($callbackString);
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
            'companies' => array(function() {
                return trim(file_get_contents(
                    __DIR__ . '/_files/companies.json'
                ));
            }),
        );
    }

}
