<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class TableList extends AbstractQuery
{
    public function __construct(RethinkInterface $rethink)
    {
        parent::__construct($rethink);

        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::TABLE_LIST,
        ];
    }
}
