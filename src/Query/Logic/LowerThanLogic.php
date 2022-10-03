<?php

namespace MCarpinter\RethinkDb\Query\Logic;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class LowerThanLogic extends AbstractQuery
{
    use OperationTrait;

    /**
     * @var QueryInterface
     */
    private $query;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        $value
    ) {
        parent::__construct($rethink);

        $this->value = $value;
        $this->rethink = $rethink;

        $this->query = $query;
    }

    public function toArray(): array
    {
        return
            [
                TermType::LT,
                [
                    $this->query->toArray(),
                    $this->value,
                ],
            ];
    }
}
