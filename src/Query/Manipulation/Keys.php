<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Manipulation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Aggregation\AggregationTrait;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\Query\Transformation\TransformationTrait;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Keys extends AbstractQuery
{
    use AggregationTrait;
    use TransformationTrait;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query
    ) {
        parent::__construct($rethink);

        $this->query   = $query;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::KEYS,
            [
                $this->query->toArray()
            ]
        ];
    }
}
