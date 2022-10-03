<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Delete extends AbstractQuery
{
    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(RethinkInterface $rethink, QueryInterface $query)
    {
        parent::__construct($rethink);

        $this->query = $query;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::DELETE,
            [
                $this->query->toArray(),
            ],
        ];
    }
}
