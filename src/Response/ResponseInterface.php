<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Response;

interface ResponseInterface
{
    public function getType(): ?int;

    /**
     * @return string|array
     */
    public function getData();

    public function isAtomic(): bool;

    public function getBacktrace(): ?array;

    public function getProfile(): ?array;

    public function getNote(): ?array;
}
