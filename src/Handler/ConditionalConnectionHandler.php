<?php

namespace Phlow\Handler;

use Phlow\Engine\Exchange;
use Phlow\Engine\ExpressionEngine;
use Phlow\Model\WorkflowConnection;
use Phlow\Model\WorkflowNode;

/**
 * Class ConditionalConnectionHandler
 * Suggests the next WorkflowNode by evaluating all the conditions assigned on the outgoing connections
 * @package Phlow\Engine\Handler
 */
class ConditionalConnectionHandler implements Handler
{
    /**
     * @var ExpressionEngine
     */
    private $expressionEngine;


    /**
     * Returns the next WorkflowNode by evaluating all the conditions assigned on the outgoing connections
     * @param WorkflowNode $workflowNode
     * @param Exchange $exchange
     * @return WorkflowNode
     */
    public function handle(WorkflowNode $workflowNode, Exchange $exchange): WorkflowNode
    {
        /** @var WorkflowConnection $connection */
        foreach ($workflowNode->getOutgoingConnections() as $connection) {
            if (!$connection->isConditional()) {
                continue;
            }

            $expression = $connection->getCondition();
            $context = (array) $exchange->getIn();
            $isTrue = $this->getExpressionEngine()->evaluate($expression, $context);
            if ($isTrue) {
                return $connection->getTarget();
            }
        }

        throw new \RuntimeException("No condition was matched. Unable to calculate the next node.");
    }

    /**
     * @return ExpressionEngine
     */
    public function getExpressionEngine(): ExpressionEngine
    {
        if (empty($this->expressionEngine)) {
            $this->expressionEngine = new ExpressionEngine();
        }

        return $this->expressionEngine;
    }

    /**
     * @param ExpressionEngine $expressionEngine
     */
    public function setExpressionEngine(ExpressionEngine $expressionEngine): void
    {
        $this->expressionEngine = $expressionEngine;
    }
}
