<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query;

use MCarpinter\RethinkDb\Response\Cursor;
use MCarpinter\RethinkDb\Response\ResponseInterface;

interface QueryInterface
{
    /**
     * @return Cursor|ResponseInterface
     */
    public function run();

    public function toArray(): array;
}
