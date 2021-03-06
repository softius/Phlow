<?php

namespace Phlow\Tests\Model;

use Phlow\Model\WorkflowBuilder;
use Phlow\Node\End;
use Phlow\Node\Start;
use Phlow\Model\NotFoundException;
use Phlow\Model\Workflow;

class WorkflowTest extends \PHPUnit\Framework\TestCase
{

    public function testGetAll()
    {
        $workflow = $this->getWorkflow();
        $this->assertEquals(2, count($workflow->getAll()));
        $this->assertEquals(1, count($workflow->getAllByClass(Start::class)));
    }

    public function testRemove()
    {
        $workflow = new Workflow();
        $end = new End();
        $start = new Start();
        $workflow->addAll($start, $end);

        $this->expectException(NotFoundException::class);
        $workflow->remove(new End());
        $this->assertEquals(2, count($workflow->getAll()));

        $workflow->remove($end);
        $this->assertEquals(1, count($workflow->getAll()));
    }

    public function testId()
    {
        $workflow = new Workflow();
        $this->assertNull($workflow->getId());

        $workflow = new Workflow('ID');
        $this->assertEquals('ID', $workflow->getId());
    }

    private function getWorkflow()
    {
        $workflow = new Workflow();
        $end = new End();
        $start = new Start();

        $workflow->addAll($start, $end);

        return $workflow;
    }
}
