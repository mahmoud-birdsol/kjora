<?php

namespace App\Jobs;

use App\Models\Advertisement;
use App\Models\Impression;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateImpressionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;

    private Advertisement $advertisement;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Advertisement $advertisement)
    {
        $this->user = $user;
        $this->advertisement = $advertisement;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Impression::create([
            'user_id' => $this->user->id,
            'advertisement_id' => $this->advertisement->id,
            'ip' => $this->user->last_known_ip,
            'source' => route('home'),
        ]);
    }
}
