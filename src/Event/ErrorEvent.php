<?php

namespace Phlow\Event;

use Phlow\Model\RenderableObject;
use Phlow\Node\AbstractNode;
use Phlow\Node\ExceptionHandler;
use Phlow\Node\ExceptionHandlerTrait;

/**
 * Class ErrorEvent
 * Represents an exception within the workflow which might trigger a different path in workflow execution.
 * @package Phlow\Event
 */
class ErrorEvent extends AbstractNode implements Event, ExceptionHandler
{
    use ExceptionHandlerTrait;
    use RenderableObject;
}
