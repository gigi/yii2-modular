<?php

namespace modules\mediator\interfaces;

/**
 * Interface EventPublisherInterface
 * @package modules\mediator\interfaces
 */
interface EventPublisherInterface
{
    /**
     * Gather replies from each subscriber
     *
     * Bellow is example of response:
     *
     * ```php
     * return [
     *     ['subscriberId' => mixed response],
     *     ['subscriberId2' => mixed response]
     * ]
     * ```
     *
     * @param $event
     * @return array
     */
    public function requestReply(EventInterface $event);

    /**
     * Asynchronous request
     *
     * @param callable $callback
     * @return void
     */
    public function requestAsync($callback = null);

    /**
     * Returns only first response
     *
     * @param $event
     * @return mixed
     */
    public function requestFirstReply(EventInterface $event);
}
