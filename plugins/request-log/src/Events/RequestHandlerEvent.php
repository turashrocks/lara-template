<?php

namespace Botble\RequestLog\Events;

use Illuminate\Queue\SerializesModels;

class RequestHandlerEvent extends \Event
{
    use SerializesModels;

    /**
     * @var mixed
     */
    public $code;

    /**
     * RequestHandlerEvent constructor.
     * @param $code
     * @author Turash Chowdhury
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     * @author Turash Chowdhury
     */
    public function broadcastOn()
    {
        return [];
    }
}
