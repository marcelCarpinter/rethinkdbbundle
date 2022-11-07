<?php

namespace MCarpinter\RethinkDb\Tests;

use \PHPUnit\Framework\TestCase;
use Mockery;

class RethinkDbTestCase extends TestCase
{
    protected function setUp(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}