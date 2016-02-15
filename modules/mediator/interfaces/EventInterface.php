<?php

namespace modules\mediator\interfaces;

/**
 * Basic mediator event
 *
 * @package modules\mediator\interfaces
 */
interface EventInterface
{
    /**
     * @return array
     */
    public function getReplies();

    /**
     * Getter for message
     * @return mixed
     */
    public function getMessage();

    /**
     * Setter for message
     * @param $message
     * @return mixed
     */
    public function setMessage($message);
}