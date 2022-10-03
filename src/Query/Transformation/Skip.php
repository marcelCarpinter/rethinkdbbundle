<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Transformation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Skip extends AbstractQuery
{
    use TransformationTrait;
    use OperationTrait;

    /**
     * @var int
     */
    private $n;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        int $n
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->n = $n;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::SKIP,
            [
                $this->query->toArray(),
                [
                    TermType::DATUM,
                    $this->n,
                ],
            ],
        ];
    }
}
