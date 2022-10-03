<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query\Aggregation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Avg extends AbstractQuery
{
    use AggregationTrait;

    /**
     * @var string
     */
    private $key;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        string $key
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->key = $key;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        return [
            TermType::AVG,
            [
                $this->query->toArray(),
                $this->key,
            ],
        ];
    }
}
