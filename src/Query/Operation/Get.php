<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Manipulation\ManipulationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Get extends AbstractQuery
{
    use ManipulationTrait;
    use OperationTrait;

    /**
     * @var string|int
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
        return [
            TermType::GET,
            [
                $this->query->toArray(),
                [
                    TermType::DATUM,
                    $this->key,
                ],
            ],
        ];
    }
}
