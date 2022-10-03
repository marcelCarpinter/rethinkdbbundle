<?php

namespace MCarpinter\RethinkDb\Query\Manipulation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Aggregation\AggregationTrait;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\Query\Transformation\TransformationTrait;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class GetField extends AbstractQuery
{
    use AggregationTrait;
    use OperationTrait;
    use TransformationTrait;

    /**
     * @var string
     */
    private $field;

    /**
     * @var QueryInterface|null
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        string $field,
        ?QueryInterface $query = null
    ) {
        parent::__construct($rethink);

        $this->field = $field;
        $this->rethink = $rethink;

        $this->query = $query;
    }

    public function toArray(): array
    {
        if ($this->query !== null) {
            return [
                TermType::GET_FIELD,
                [
                    $this->query->toArray(),
                    $this->field,
                ],
            ];
        }

        return [
            TermType::GET_FIELD,
            [
                [
                    TermType::IMPLICIT_VAR,
                    [],
                ],
                $this->field,
            ],
        ];
    }
}
