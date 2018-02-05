<?php

namespace Botble\Note\Listeners;

use Botble\Base\Events\DeletedContentEvent;
use Exception;
use Note;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     * @author Turash Chowdhury
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            Note::deleteNote($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
