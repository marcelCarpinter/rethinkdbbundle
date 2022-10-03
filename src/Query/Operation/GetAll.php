<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Aggregation\AggregationTrait;
use MCarpinter\RethinkDb\Query\Manipulation\ManipulationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\Query\Transformation\TransformationTrait;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class GetAll extends AbstractQuery
{
    use AggregationTrait;
    use OperationTrait;
    use TransformationTrait;
    use ManipulationTrait;

    /**
     * @var array
     */
    private $keys;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        array $keys
    ) {
        parent::__construct($rethink);

        $this->query   = $query;
        $this->keys    = $keys;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::GET_ALL,
            array_merge(
                [$this->query->toArray()],
                array_values($this->keys)
            ),
        ];
    }
}
