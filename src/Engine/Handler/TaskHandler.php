<?php

namespace Phlow\Engine\Handler;

use Phlow\Activity\Task;
use Phlow\Engine\Exchange;
use Phlow\Model\Workflow\WorkflowNode;

class TaskHandler implements Handler
{

    /**
     * @param WorkflowNode $workflowNode
     * @param Exchange $exchange
     * @return WorkflowNode
     * @throws \Exception
     */
    public function handle(WorkflowNode $workflowNode, Exchange $exchange): WorkflowNode
    {
        if (!($workflowNode instanceof Task)) {
            throw new \InvalidArgumentException("A workflow node of type Task was expected.");
        }

        /** @var Task $task */
        $task = $workflowNode;
        try {
            // Invoke callback
            if ($task->hasCallback()) {
                $callback = $task->getCallback();
                $exchange->setOut(
                    call_user_func($callback, $exchange->getIn())
                );
            }

            // Return next node
            return (new SingleConnectionHandler())->handle($workflowNode, $exchange);
        } catch (\Exception $e) {
            // @todo add error handling event
            // Rethrow Exception in case no error handling was defined
            throw $e;
        }
    }
}
