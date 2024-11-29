<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SaveUserLastLogin implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $userId, private $time)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Update the user's last login time
        $user = User::find($this->userId);
        $user->last_login_at = $this->time;
        $user->save();
    }
}
