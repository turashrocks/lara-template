<?php

namespace Botble\Base\Listeners;

use Botble\Base\Events\CreatedContentEvent;
use Exception;

class CreatedContentListener
{

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     * @author Turash Chowdhury
     */
    public function handle(CreatedContentEvent $event)
    {
        try {
            do_action(BASE_ACTION_AFTER_CREATE_CONTENT, $event->screen, $event->request, $event->data);

            cache()->forget('public.sitemap');
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
