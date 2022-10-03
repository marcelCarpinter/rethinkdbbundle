<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Changes extends AbstractQuery
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        ?array $options
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->rethink = $rethink;
        $this->options = $options;
    }

    public function toArray(): array
    {
        $query = [
            TermType::CHANGES,
            [
                $this->query->toArray(),
            ],
        ];

        if (!empty($this->options)) {
            $query[] = $this->options;
        }

        return $query;
    }
}
