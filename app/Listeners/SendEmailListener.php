<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Mail\SendNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendEmail  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        $when = Carbon::now()->addMinutes(1);


        Mail::to(User::all())
          //  ->send(new SendNotification($event->thread));
           ->later($when, new SendNotification($event->thread));
    }
}
