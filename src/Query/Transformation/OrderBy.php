<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query\Transformation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class OrderBy extends AbstractQuery
{
    use TransformationTrait;
    use OperationTrait;

    /**
     * @var mixed|QueryInterface
     */
    private $key;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        $key
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->key = $key;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        $ordering = $this->key instanceof QueryInterface ? $this->key->toArray() : $this->key;

        return [
            TermType::ORDER_BY,
            [
                $this->query->toArray(),
                $ordering,
            ],
        ];
    }
}
