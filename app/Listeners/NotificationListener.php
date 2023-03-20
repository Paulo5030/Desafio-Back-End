<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Service\MockService;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationListener implements ShouldQueue
{
    public function handle(SendNotification $event)
    {
       app(MockService::class)->notifyUser($event->transaction->wallet->user->id);
    }
}