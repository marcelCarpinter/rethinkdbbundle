<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Connection;

use MCarpinter\RethinkDb\Message\MessageInterface;
use MCarpinter\RethinkDb\Response\ResponseInterface;

interface ConnectionQueryInterface
{
    public function writeQuery(int $token, MessageInterface $message): int;

    public function continueQuery(int $token): ResponseInterface;

    public function stopQuery(int $token): ResponseInterface;
}
