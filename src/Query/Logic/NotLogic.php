<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query\Logic;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class NotLogic extends AbstractQuery
{
    use OperationTrait;

    /**
     * @var QueryInterface
     */
    private $query;
    
    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query
    ) {
        parent::__construct($rethink);

        $this->rethink = $rethink;
        $this->query = $query;
    }

    public function toArray(): array
    {
        return
            [
                TermType::NOT,
                [
                    $this->query->toArray(),
                ],
            ];
    }
}
