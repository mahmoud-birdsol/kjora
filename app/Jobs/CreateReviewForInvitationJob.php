<?php

namespace App\Jobs;

use App\Models\Invitation;
use App\Notifications\NotifyPlayerOfReviewNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateReviewForInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invitations = Invitation::whereDoesntHave('reviews')
//            ->where('date', now()->addHours(2))
            ->get()->each(function (Invitation $invitation) {
                $firstReview = $invitation->reviews()->create([
                    'reviewer_id' => $invitation->invitingPlayer->id,
                    'player_id' => $invitation->invitedPlayer->id
                ]);

                $invitation->invitingPlayer->notify(
                    new NotifyPlayerOfReviewNotification(
                        $invitation->invitingPlayer,
                        $invitation->invitedPlayer,
                        $firstReview
                    )
                );

                $secondReview = $invitation->reviews()->create([
                    'reviewer_id' => $invitation->invitedPlayer->id,
                    'player_id' => $invitation->invitingPlayer->id
                ]);


                $invitation->invitedPlayer->notify(
                    new NotifyPlayerOfReviewNotification(
                        $invitation->invitedPlayer,
                        $invitation->invitingPlayer,
                        $secondReview
                    )
                );
            });
    }
}
