<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Connection;

use MCarpinter\RethinkDb\Message\MessageInterface;
use MCarpinter\RethinkDb\Response\ResponseInterface;

interface ConnectionInterface
{
    public function close($noreplyWait = true): void;

    public function connect(): Connection;

    public function expr(string $string): ResponseInterface;

    public function noreplyWait(): void;

    public function reconnect($noreplyWait = true): Connection;

    public function run(MessageInterface $message);

    public function runNoReply(MessageInterface $query): void;

    public function server(): ResponseInterface;

    public function use(string $name): void;
}
