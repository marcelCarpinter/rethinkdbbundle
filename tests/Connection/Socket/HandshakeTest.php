<?php

namespace MCarpinter\RethinkDb\Tests\Connection\Socket;

use _PHPStan_3bfe2e67c\Nette\Neon\Exception;
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
        $stream = \Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('isWritable')->atLeast()->andReturn(false);
        $stream->shouldReceive('close');

        $this->handshake->hello($stream);
        $this->expectException(Exception::class);
    }

    /**
     *
     */
    public function testExceptionThrownOnError(): void
    {
        $stream = \Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
        $stream->shouldReceive('close');
        $stream->shouldReceive('write');
        $stream->shouldReceive('getContents')->atLeast()->andReturn('ERROR: Foobar');

        $this->handshake->hello($stream);
        $this->expectException(Exception::class);
    }

    /**
     *
     */
    public function testExceptionThrownOnVerifyProtocolWithError(): void
    {
        $stream = \Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
        $stream->shouldReceive('close');
        $stream->shouldReceive('write');
        $stream->shouldReceive('getContents')->atLeast()->andReturn('{"success":false, "error": "Foobar"}');

        $this->handshake->hello($stream);
        $this->expectException(Exception::class);
    }

    /**
     *
     */
    public function testExceptionThrownOnInvalidProtocolVersion(): void
    {
        $stream = \Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
        $stream->shouldReceive('close');
        $stream->shouldReceive('write');
        $stream->shouldReceive('getContents')->atLeast()
            ->andReturn('{"success":true, "max_protocol_version": 1, "min_protocol_version": 1}');

        $this->handshake->hello($stream);
        $this->expectException(Exception::class);
    }


    /**
     *
     */
    public function testExceptionThrownOnProtocolError(): void
    {
        /** @var MockInterface $stream */
        $stream = \Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('isWritable')->atLeast()->andReturn(true);
        $stream->shouldReceive('close');
        $stream->shouldReceive('write');
        $stream->shouldReceive('getContents')->atLeast()->andReturn('ERROR: Woops!');

        $this->handshake->hello($stream);
        $this->expectException(Exception::class);
    }
}