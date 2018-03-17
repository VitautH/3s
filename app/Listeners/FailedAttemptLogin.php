<?php

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FailedAttemptLogin
{
    const MAX_FAILED_ATTEMPT = 4;

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
     * @param  Failed $event
     * @return void
     */
    public function handle(Failed $event)
    {
        if ($user = User::all()->where('login', $event->credentials['login'])->first()) {
            if ($user->is_block != 1) {
                if ($user->failed_attempt == self::MAX_FAILED_ATTEMPT) {
                    $user->failed_attempt++;
                    $user->is_block = 1;
                } else {
                    $user->failed_attempt++;
                }
                $user->save();
            }
        }
    }
}
