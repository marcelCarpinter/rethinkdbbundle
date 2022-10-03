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

class Filter extends AbstractQuery
{
    use TransformationTrait;
    use OperationTrait;
    use AggregationTrait;
    use ManipulationTrait;

    /**
     * @var array
     */
    private $predicate;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        array $predicate
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->predicate = [$predicate];
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        $jsonDocuments = [];
        foreach ($this->predicate as $key => $document) {
            $jsonDocuments[] = json_encode($document);
        }

        return [
            TermType::FILTER,
            [
                $this->query->toArray(),
                [
                    TermType::JSON,
                    $jsonDocuments,
                ],
            ],
        ];
    }
}
