<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Aggregation\AggregationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\Query\Transformation\TransformationTrait;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Between extends AbstractQuery
{
    use AggregationTrait;
    use OperationTrait;
    use TransformationTrait;

    /**
     * @var QueryInterface
     */
    private $query;

    /**
     * @var string
     */
    private $min;

    /**
     * @var string
     */
    private $max;

    /**
     * @var array|null
     */
    private $options;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        $min,
        $max,
        array $options = null
    ) {
        parent::__construct($rethink);

        $this->rethink = $rethink;
        $this->query = $query;
        $this->min = $min;
        $this->max = $max;
        $this->options = $options;
    }

    public function toArray(): array
    {
        $args = [
            $this->query->toArray(),
            $this->min,
            $this->max,
        ];

        if ($this->options !== null) {
            $args = array_merge($args, [$this->options]);
        }

        return [
            TermType::BETWEEN,
            $args,
        ];
    }
}
