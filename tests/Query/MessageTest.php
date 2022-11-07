<?php

namespace MCarpinter\RethinkDb\Tests\Query;

use MCarpinter\RethinkDb\Message\Message;
use MCarpinter\RethinkDb\Query\Options;
use MCarpinter\RethinkDb\Tests\RethinkDbTestCase;

class MessageTest extends RethinkDbTestCase
{
    /**
     * @return void
     * @throws \Exception
     */
    public function testAccessors(): void
    {
        $queryType = 1;
        $query = ['yo'];
        $options = new Options();
        $message = new Message();

        $message->setCommand($queryType);
        $message->setQuery($query);
        $message->setOptions($options);

        $this->assertEquals(1, $message->getQueryType());
        $this->assertEquals([
            1,
            ['yo'],
            new Options(),
        ], $message->toArray());
        $this->assertEquals($options, $message->getOptions());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testToArray(): void
    {
        $queryType = 1;
        $query = [];
        $options = new Options();

        $message = new Message($queryType, $query, $options);

        $expectedResults = [
            1,
            $query,
            (object) $options,
        ];

        $this->assertEquals($expectedResults, $message->toArray());
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testJsonSerialize(): void
    {
        $queryType = 1;
        $query = [];
        $options = new Options();

        $message = new Message($queryType, $query, $options);

        $expectedResults = [
            1,
            $query,
            (object) $options,
        ];

        $this->assertEquals($expectedResults, $message->jsonSerialize());
    }
}