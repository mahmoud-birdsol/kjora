<?php

namespace App\Jobs;

use App\Models\Advertisement;
use App\Models\Impression;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateImpressionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Illuminate\Http\Request
     */
    private Request $request;

    /**
     * @var \App\Models\Advertisement
     */
    private Advertisement $advertisement;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, Advertisement $advertisement)
    {
        $this->request = $request;
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
            'user_id' => $this->request->user()->id,
            'advertisement_id' => $this->advertisement->id,
            'ip' => $this->request->user()->last_known_ip,
            'source' => route('home')
        ]);
    }
}
