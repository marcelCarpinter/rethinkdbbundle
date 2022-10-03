<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query;

use MCarpinter\RethinkDb\Message\Message;
use MCarpinter\RethinkDb\Message\MessageInterface;
use MCarpinter\RethinkDb\RethinkInterface;

abstract class AbstractQuery implements QueryInterface
{
    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var RethinkInterface
     */
    protected $rethink;

    public function __construct(RethinkInterface $rethink)
    {
        $this->rethink = $rethink;
    }

    public function run()
    {
        $message = new Message();
        $message->setQuery($this->toArray());

        return $this->rethink->connection()->run($message);
    }

    abstract public function toArray(): array;
}
