<?php

namespace Phlow\Tests\Activity;

use Phlow\Node\Callback;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testWithCallback()
    {
        $task = new Callback();
        $cb = function ($d) {
            return $d;
        };
        $task->addCallback($cb);

        $this->assertTrue($task->hasCallback());
        $this->assertEquals($cb, $task->getCallback());
    }

    public function testWithoutCallbacks()
    {
        $task = new Callback();
        $this->assertFalse($task->hasCallback());
        $this->expectException(\UnexpectedValueException::class);
        $task->getCallback();
    }
}
