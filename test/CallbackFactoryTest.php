<?php

namespace AssemblyTest\Callback;

use Assembly\Callback\CallbackFactory;
use PHPUnit\Framework\TestCase;

/**
 * @group      Assembly_Callback
 */
class CallbackFactoryTest extends TestCase
{

    /**
     * Test registering a new type
     *
     * @param        string $type
     * @param        string $class
     * @dataProvider registeringNewTypeProvider
     */
    public function testRegisteringNewType($type, $class)
    {
        $this->assertAttributeNotContains(
            $class,
            'typeClasses',
            '\Assembly\Callback\CallbackFactory'
        );
        CallbackFactory::registerType($type, $class);
        $this->assertAttributeContains(
            $class,
            'typeClasses',
            '\Assembly\Callback\CallbackFactory'
        );
        CallbackFactory::unregisterType($type);
        $this->assertAttributeNotContains(
            $class,
            'typeClasses',
            '\Assembly\Callback\CallbackFactory'
        );
    }

    /**
     * Provide the data for testRegisteringNewType
     */
    public function registeringNewTypeProvider()
    {
        return array(
            array('foo', 'Foo\Bar\Class'),
            array('fimpy', 'No real class at all!!!'),
        );
    }

    /**
     * Test creation of new Callback with an existing type class
     *
     * @param string $callback           The callback to create
     * @param string $expectedClass The class expected
     *
     * @dataProvider createCallbackWithFactoryProvider
     */
    public function testCreateCallbackWithFactory($callback, $expectedClass)
    {
        $class = CallbackFactory::factory($callback());
        $this->assertInstanceof($expectedClass, $class);
    }

    /**
     * Provide the data for the testCreateCallbackWithFactory
     *
     * @return array
     */
    public function createCallbackWithFactoryProvider()
    {
        return array(
            'items' => array(
                function() {
                    return trim(file_get_contents(
                        __DIR__ . '/_files/items.json'
                    ));
                },
                'Assembly\Callback\Item'
            ),
            'users' => array(
                function() {
                    return trim(file_get_contents(
                        __DIR__ . '/_files/users.json'
                    ));
                },
                'Assembly\Callback\User'
            ),
            'companies' => array(
                function() {
                    return trim(file_get_contents(
                        __DIR__ . '/_files/companies.json'
                    ));
                },
                'Assembly\Callback\Company'
            ),
            'accounts' => array(
                function() {
                    return trim(file_get_contents(
                        __DIR__ . '/_files/accounts.json'
                    ));
                },
                'Assembly\Callback\Account'
            ),
            'transactions' => array(
                function() {
                    return trim(file_get_contents(
                        __DIR__ . '/_files/transactions.json'
                    ));
                },
                'Assembly\Callback\Transaction'
            ),
            'batch_transactions' => array(
                function() {
                    return trim(file_get_contents(
                        __DIR__ . '/_files/batch_transactions.json'
                    ));
                },
                'Assembly\Callback\BatchTransaction'
            ),
        );
    }

    /**
     * Test that unknown type will result in an exception
     *
     * @param string $callback a callback with an unknown scheme
     * @expectedException InvalidArgumentException
     * @dataProvider unknownTypeThrowsExceptionProvider
     */
    public function testUnknownTypeThrowsException($callback)
    {
        $c = CallbackFactory::factory($callback);
    }

    /**
     * Provide data to the unknownTypeThrowsException Test
     *
     * @return array
     */
    public function unknownTypeThrowsExceptionProvider()
    {
        return array(
            array(
                json_encode(
                    array('bogus' => array('bogus_thing' => 'nothingness'))
                )
            ),
        );
    }
}
