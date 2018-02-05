<?php

namespace Botble\Base\Events;

use Illuminate\Queue\SerializesModels;

class SendMailEvent extends Event
{
    use SerializesModels;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $title;

    /**
     * @var array
     */
    public $args;

    /**
     * SendMailEvent constructor.
     * @param $content
     * @param $title
     * @param $args
     * @author Turash Chowdhury
     */
    public function __construct($content, $title, $args)
    {
        $this->content = $content;
        $this->title = $title;
        $this->args = $args;
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
