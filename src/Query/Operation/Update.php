<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Update extends AbstractQuery
{
    /**
     * @var array
     */
    private $elements;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        array $elements
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->elements = $elements;
        $this->rethink = $rethink;
    }

    public function toArray(): array
    {
        $jsonElements = json_encode($this->elements);

        return [
            TermType::UPDATE,
            [
                $this->query->toArray(),
                [
                    TermType::JSON,
                    [
                        $jsonElements
                    ],
                ],
            ],
        ];
    }
}
