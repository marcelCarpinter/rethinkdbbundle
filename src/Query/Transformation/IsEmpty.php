<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Transformation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class IsEmpty extends AbstractQuery
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
            TermType::IS_EMPTY,
            [
                $this->query->toArray(),
            ],
        ];
    }
}
