<?php

namespace App\Listeners;

use Illuminate\Foundation\Http\Events\RequestHandled;

class RequestHandledListener
{
    /**
     * Handle the event.
     *
     * @param RequestHandled $event
     *
     * @return void
     */
    public function handle(RequestHandled $event)
    {
        $content = $event->response->content();

        $event->response->setContent(\FineUIPHP\ResourceManager\ResourceManager::finish($content));
    }
}
