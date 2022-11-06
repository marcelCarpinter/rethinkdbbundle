<?php

use MCarpinter\RethinkDb\Connection\Connection;
use MCarpinter\RethinkDb\Connection\ConnectionException;
use MCarpinter\RethinkDb\Connection\Options;
use MCarpinter\RethinkDb\Connection\Registry;

class RegistryTest extends \MCarpinter\RethinkDb\Tests\RethinkDbTest
{
    /**
     * @return void
     * @throws \Exception
     * @throws ConnectionException
     */
    public function testIfRegistryGetsConstructedWithConnections(): void
    {
        $optionsConfig = [
            'dbname' => 'foo',
        ];

        $options = new Options($optionsConfig);

        $options2Config = [
            'dbname' => 'bar',
        ];

        $options2 = new Options($options2Config);

        $registry = new Registry(
            [
                'fooConnection' => $options,
                'barConnection' => $options2,
                'bazConnection' => [],
            ]
        );

        $this->assertTrue($registry->hasConnection('fooConnection'));
        $this->assertTrue($registry->hasConnection('barConnection'));
        $this->assertFalse($registry->hasConnection('bazConnection'));

        $this->assertInstanceOf(Connection::class, $registry->getConnection('fooConnection'));
        $this->assertInstanceOf(Connection::class, $registry->getConnection('barConnection'));
    }

    /**
     * @return void
     * @throws ConnectionException
     */
    public function testIfExceptionThrownOnDuplicateConnection(): void
    {
        $optionsConfig = [
            'dbname' => 'foo',
        ];

        $options = new Options($optionsConfig);

        $registry = new Registry(
            [
                'fooConnection' => $options,
            ]
        );
        $this->expectException(ConnectionException::class);
        $registry->addConnection('fooConnection', $options);
    }

    /**
     * @return void
     * @throws ConnectionException
     */
    public function testIfExceptionThrownOnMissingConnection(): void
    {
        $registry = new Registry([]);
        $this->expectException(ConnectionException::class);
        $registry->getConnection('fooConnection');
    }
}