<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb\Query\Logic;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class OrLogic extends AbstractQuery
{
    use OperationTrait;

    /**
     * @var QueryInterface
     */
    private $functionOne;

    /**
     * @var QueryInterface
     */
    private $functionTwo;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $functionOne,
        QueryInterface $functionTwo
    ) {
        parent::__construct($rethink);

        $this->rethink = $rethink;

        $this->functionOne = $functionOne;
        $this->functionTwo = $functionTwo;
    }

    public function toArray(): array
    {
        return
            [
                TermType::OR,
                [
                    $this->functionOne->toArray(),
                    $this->functionTwo->toArray(),
                ],
            ];
    }
}
