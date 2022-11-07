<?php

namespace MCarpinter\RethinkDb\Tests\Connection;

use MCarpinter\RethinkDb\Message\MessageInterface;
use MCarpinter\RethinkDb\Response\ResponseInterface;
use MCarpinter\RethinkDb\Types\Response\ResponseType;
use Exception;

class ConnectionCursorTest extends ConnectionTestCase
{
    public function testRewindFromCursor()
    {
        $this->connect();

        $message = \Mockery::mock(MessageInterface::class);
        $message->shouldReceive('setOptions')->once();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::SUCCESS_ATOM);

        $this->setExpectations($response);

        try {
            $this->connection->rewindFromCursor($message);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}