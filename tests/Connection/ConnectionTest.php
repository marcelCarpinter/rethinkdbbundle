<?php

namespace MCarpinter\RethinkDb\Tests\Connection;

use Exception;
use MCarpinter\RethinkDb\Connection\ConnectionException;
use MCarpinter\RethinkDb\Message\MessageInterface;
use MCarpinter\RethinkDb\Response\Cursor;
use MCarpinter\RethinkDb\Response\ResponseInterface;
use MCarpinter\RethinkDb\Types\Query\QueryType;
use MCarpinter\RethinkDb\Types\Response\ResponseType;

class ConnectionTest extends ConnectionTestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return void
     * @throws ConnectionException
     */
    public function testConnectThrowsCorrectException(): void
    {
        $this->handshake->shouldReceive('hello')->once()->andThrow(
            new ConnectionException('Test exception')
        );
        $this->expectException(ConnectionException::class);
        $this->connection->connect();
    }

    /**
     * @throws ConnectionException
     */
    public function testQueryWithoutConnection(): void
    {
        try{
            $this->connection->writeQuery(1223456789, \Mockery::mock(MessageInterface::class));
        }
        catch(ConnectionException $e){
            $this->assertTrue(true);
        }
    }

    /**
     * @throws ConnectionException
     */
    public function testExpr()
    {
        $this->connect();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::SUCCESS_ATOM);

        $this->setExpectations($response);

        $this->connection->expr('foo');
    }

    public function testRunAtom()
    {
        $this->connect();

        $message = \Mockery::mock(MessageInterface::class);
        $message->shouldReceive('setOptions')->once()->andReturn();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::SUCCESS_ATOM);

        $this->setExpectations($response);

        try {
            $this->assertInstanceOf(ResponseInterface::class, $this->connection->run($message, false));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function testRunPartial()
    {
        $this->connect();

        $message = \Mockery::mock(MessageInterface::class);
        $message->shouldReceive('setOptions')->once()->andReturn();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::SUCCESS_PARTIAL);
        $response->shouldReceive('getData')->atLeast()->andReturn(['yolo']);
        $response->shouldReceive('isAtomic')->once()->andReturn(true);

        $this->setExpectations($response);

        try {
            $this->assertInstanceOf(Cursor::class, $this->connection->run($message, false));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function testRunSequence()
    {
        $this->connect();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::SUCCESS_SEQUENCE);
        $response->shouldReceive('getData')->atLeast()->andReturn(['yolo']);
        $response->shouldReceive('isAtomic')->once()->andReturn(true);

        $this->setExpectations($response);

        $message = \Mockery::mock(MessageInterface::class);
        $message->shouldReceive('setOptions')->once()->andReturn();

        try {
            $this->assertInstanceOf(Cursor::class, $this->connection->run($message, false));
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function testServer(): void
    {
        $this->connect();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::SERVER_INFO);
        $response->shouldReceive('getData')->atLeast()->andReturn(['yolo']);

        $this->setExpectations($response);

        $res = $this->connection->server();

        $this->assertEquals(QueryType::SERVER_INFO, $res->getType());
        $this->assertTrue(is_array($res->getData()));
        $this->assertEquals(['yolo'], $res->getData());
    }

    /**
     * @throws Exception
     */
    public function testRunNoReply()
    {
        $this->connect();

        $message = \Mockery::mock(MessageInterface::class);
        $message->shouldReceive('setOptions')->once()->andReturn();

        $this->setExpectations();

        try {
            $this->assertEmpty($this->connection->runNoReply($message));
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testClose(): void
    {
        $this->connect();

        $this->stream->shouldReceive('close')->once();

        try {
            $this->connection->close(false);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testCloseNoReplyWait(): void
    {
        $this->connect();

        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getType')->atLeast()->andReturn(ResponseType::WAIT_COMPLETE);

        $this->setExpectations($response);

        $this->stream->shouldReceive('close')->once();

        try {
            $this->connection->close(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testUse()
    {
        try {
            $this->connection->use('test');
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}