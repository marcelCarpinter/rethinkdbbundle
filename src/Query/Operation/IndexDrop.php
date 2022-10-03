<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class IndexDrop extends AbstractQuery
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        string $name
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->rethink = $rethink;

        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            TermType::INDEX_DROP,
            [
                $this->query->toArray(),
                [
                    TermType::DATUM,
                    $this->name,
                ],
            ],
        ];
    }
}
