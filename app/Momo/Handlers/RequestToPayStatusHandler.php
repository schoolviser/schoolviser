<?php

namespace App\Momo\Handlers;

abstract  class RequestToPayStatusHandler
{
     /**
     * Handle the action to be performed when the RTP is successful.
     *
     * @param array $data
     * @return void
     */
    abstract public function handle(array $data): void;

    /**
     * Called on successful execution of the action.
     *
     * @return void
     */
    public function onSuccess(): void
    {
        // Log success, notify users, etc.
    }

    /**
     * Called on failure to execute the action.
     *
     * @return void
     */
    public function onFailure(): void
    {
        // Log failure, retry logic, etc.
    }
}
