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

class Without extends AbstractQuery
{
    use AggregationTrait;
    use OperationTrait;
    use TransformationTrait;

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
        $this->rethink = $rethink;
        $this->keys    = $keys;
    }

    public function toArray(): array
    {
        if (\count($this->keys) === 1) {
            $keysQuery = implode($this->keys);
        } else {
            $keysQuery =  [
                TermType::MAKE_ARRAY,
                array_values($this->keys)
            ];
        }

        return [
            TermType::WITHOUT,
            [
                $this->query->toArray(),
                $keysQuery
            ]
        ];
    }
}
