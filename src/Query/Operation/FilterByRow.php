<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Manipulation\ManipulationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\Query\Transformation\TransformationTrait;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class FilterByRow extends AbstractQuery
{
    use TransformationTrait;
    use OperationTrait;
    use ManipulationTrait;

    /**
     * @var QueryInterface
     */
    private $functionQuery;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        QueryInterface $manipulation
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->functionQuery = $manipulation;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::FILTER,
            [
                $this->query->toArray(),
                $this->functionQuery->toArray(),
            ],
        ];
    }
}
