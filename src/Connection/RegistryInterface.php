<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Connection;

interface RegistryInterface
{
    public function addConnection(string $name, OptionsInterface $options): bool;

    public function hasConnection(string $name): bool;

    public function getConnection(string $name): ConnectionInterface;
}
