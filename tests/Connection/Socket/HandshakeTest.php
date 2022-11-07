<?php

namespace MCarpinter\RethinkDb\Tests\Connection\Socket;

use MCarpinter\RethinkDb\Connection\Socket\Exception;
use MCarpinter\RethinkDb\Connection\Socket\Handshake;
use MCarpinter\RethinkDb\Tests\RethinkDbTestCase;
use Mockery\MockInterface;
use Psr\Http\Message\StreamInterface;

class HandshakeTest extends RethinkDbTestCase
{
    /**
     * @var Handshake
     */
    private $handshake;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->handshake = new Handshake('foo', 'bar', 42);
    }

    /**
     *
     */
    public function testExceptionThrownOnStreamNotWritable(): void
    {
        try{
            $stream = \Mockery::mock(StreamInterface::class);
            $stream->shouldReceive('isWritable')->atLeast()->andReturn(false);
            $stream->shouldReceive('close');

            $this->handshake->hello($stream);
        }
        catch (Exception $e){
            $this->assertEquals("Not connected", $e->getMessage());
        }
    }

    /**
     *
     */
    public function testExceptionThrownOnError(): void
    {
        try{
            $stream = \Mockery::mock(StreamInterface::class);
            $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
            $stream->shouldReceive('close');
            $stream->shouldReceive('write');
            $stream->shouldReceive('getContents')->atLeast()->andReturn('ERROR: Foobar');

            $this->handshake->hello($stream);
            $this->expectException(Exception::class);
        }
        catch (Exception $e){
            $this->assertEquals("Foobar", $e->getMessage());
        }
    }

    /**
     *
     */
    public function testExceptionThrownOnVerifyProtocolWithError(): void
    {
        try{
            $stream = \Mockery::mock(StreamInterface::class);
            $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
            $stream->shouldReceive('close');
            $stream->shouldReceive('write');
            $stream->shouldReceive('getContents')->atLeast()->andReturn('{"success":false, "error": "Foobar"}');

            $this->handshake->hello($stream);
            $this->expectException(Exception::class);
        }
        catch (Exception $e){
            $this->assertEquals("Handshake failed: Foobar", $e->getMessage());
        }
    }

    /**
     *
     */
    public function testExceptionThrownOnInvalidProtocolVersion(): void
    {
        try{
            $stream = \Mockery::mock(StreamInterface::class);
            $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
            $stream->shouldReceive('close');
            $stream->shouldReceive('write');
            $stream->shouldReceive('getContents')->atLeast()
                ->andReturn('{"success":true, "max_protocol_version": 1, "min_protocol_version": 1}');

            $this->handshake->hello($stream);
            $this->expectException(Exception::class);
        }
        catch (Exception $e){
            $this->assertEquals("Unsupported protocol version.", $e->getMessage());
        }
    }


    /**
     *
     */
    public function testExceptionThrownOnProtocolError(): void
    {
        try{
            /** @var MockInterface $stream */
            $stream = \Mockery::mock(StreamInterface::class);
            $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
            $stream->shouldReceive('close');
            $stream->shouldReceive('write');
            $stream->shouldReceive('getContents')->atLeast()->andReturn('ERROR: Woops!');

            $this->handshake->hello($stream);
            $this->expectException(Exception::class);
        }
        catch (Exception $e){
            $this->assertEquals("Woops!", $e->getMessage());
        }
    }
}