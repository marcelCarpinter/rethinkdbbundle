<?php

namespace MCarpinter\RethinkDb\Message;

use MCarpinter\RethinkDb\Query\Options;
use MCarpinter\RethinkDb\Query\OptionsInterface;
use MCarpinter\RethinkDb\Types\Query\QueryType;

class ExprMessage implements MessageInterface
{
    /**
     * @var OptionsInterface
     */
    private $options;

    /**
     * @var string
     */
    private $query;

    /**
     * @var int
     */
    private $queryType;

    public function __construct(int $queryType = null, string $query = '', OptionsInterface $options = null)
    {
        $this->queryType = $queryType ?? QueryType::START;
        $this->query = $query ?? '';
        $this->options = $options ?? new Options();
    }

    public function getQueryType(): int
    {
        return $this->queryType;
    }

    public function setCommand(int $queryType): MessageInterface
    {
        $this->queryType = $queryType;

        return $this;
    }

    public function setQuery($query): MessageInterface
    {
        $this->query = (string) $query;

        return $this;
    }

    public function getOptions(): OptionsInterface
    {
        return $this->options;
    }

    public function setOptions(OptionsInterface $options): MessageInterface
    {
        $this->options = $options;

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->queryType,
            $this->query,
            (object) $this->getOptions(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
