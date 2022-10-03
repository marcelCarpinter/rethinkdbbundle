<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Connection;

use MCarpinter\RethinkDb\Message\MessageInterface;
use MCarpinter\RethinkDb\Response\ResponseInterface;

interface ConnectionCursorInterface extends ConnectionQueryInterface
{
    /**
     * @throws ConnectionException
     */
    public function rewindFromCursor(MessageInterface $message): ResponseInterface;
}
