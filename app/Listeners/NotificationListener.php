<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Service\AuthorizeTransaction\AuthorizeTransactionService;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationListener implements ShouldQueue
{
    public function handle(SendNotification $event)
    {
        app(AuthorizeTransactionService::class)->notifyUser($event->transaction->wallet->user->id);
    }
}
