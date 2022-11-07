<?php

namespace MCarpinter\RethinkDb\Tests;

use \PHPUnit\Framework\TestCase;
use Mockery;

class RethinkDbTestCase extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    protected function setUp(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

        parent::setUp();
    }
}