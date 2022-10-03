<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query\Aggregation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Count extends AbstractQuery
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
            TermType::COUNT,
            [
                $this->query->toArray(),
            ],
        ];
    }
}
