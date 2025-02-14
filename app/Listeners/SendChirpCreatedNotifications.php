<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
        Log::info("handle created construct");
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        Log::info("handle chirpcreated");
        foreach (User::where('id', $event->chirp->user_id)->cursor() as $user) {
            Log::info('notifying' . $user);
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
