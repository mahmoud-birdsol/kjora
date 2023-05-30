<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\InvitationCreatedNotification;
use App\Services\FlashMessage;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class InvitationController extends Controller
{
    /**
     * Display the invitations index page.
     */
    public function index(Request $request): Response
    {
        $query = Invitation::where('invited_player_id', $request->user()->id)
            ->latest('date')
            ->with('invitingPlayer')
            ->with(['reviews' => function ($q) use ($request) {
                $q->whereNot('player_id', '=', $request->user()->id)->whereDoesntHave('ratingCategories');
            }])
            ->with('stadium');

        $request->whenFilled('search', fn () => $query->where(function ($query) use ($request) {
            $query->whereHas('invitingPlayer', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('username', 'LIKE', '%' . $request->input('search') . '%');
            });
        }));

        $request->whenFilled(
            'dateFrom',
            fn () => $query->where('date', '>=', \Carbon\Carbon::parse($request->input('dateFrom'))->toDatetimeString())
        );
        $request->whenFilled(
            'dateTo',
            fn () => $query->where('date', '<=', \Carbon\Carbon::parse($request->input('dateTo'))->toDatetimeString())
        );

        return Inertia::render('Invitation/Index', [
            'invitations' => $query->paginate(10),
        ]);
    }

    /**
     * Store a new invitation.
     *
     * @param \App\Http\Requests\InvitationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InvitationRequest $request): RedirectResponse
    {
        //        if ($request->user()->hasPendingReviews()) {
        //            FlashMessage::make()->success(
        //                message: "You can't invite another player because you have a pending rating"
        //            )->closeable()->send();
        //
        //            return redirect()->back()->withErrors([
        //                'review' => "You can't invite another player because you have a pending rating",
        //            ]);
        //        }
        $data = $request->validated();

        $time = Carbon::parse($data['time']);
        $data['inviting_player_id'] = $request->user()->id;
        $data['date'] = Carbon::parse($data['date'])->setTime($time->hour, $time->minute);
        $date = Carbon::parse($data['date'])->setTime($time->hour, $time->minute);

        unset($data['time']);

        // checks if the invited player has an invitation at the same time
        $invitedPlayer = User::findOrFail($request->input('invited_player_id'));
        //check if user invite player and user have invitation
        if ($request->user()->hasApprovedHiresForSamePlayer(
            CarbonImmutable::parse($data['date'])
                ->setTime($time->hour, $time->minute),
            $invitedPlayer
        )) {
            FlashMessage::make()->success(
                message: __("You already invited this player at the same match")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You already invited this player at the same match"),
            ]);
        }

        //check if user invite player and user have invitation
        if ($request->user()->hasApprovedInvitationsForSamePlayer(
            CarbonImmutable::parse($data['date'])
                ->setTime($time->hour, $time->minute),
            $invitedPlayer
        )) {
            FlashMessage::make()->success(
                message: __("You already invited this player at the same match")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You already invited this player at the same match"),
            ]);
        }


        $date = Carbon::parse($data['date'])->setTime($time->hour, $time->minute);
        // check if player because he has an invitation at the same time
        if (
            $request->user()->invitations()
            ->where('date', '!=', $date)
            ->whereRaw('DATE_ADD(`date`, INTERVAL 2 HOUR) > ?', [$date])
            ->whereRaw('DATE_SUB(`date`, INTERVAL 2 HOUR) < ?', [$date])
            ->where('state', 'accepted')
            ->get()->count() > 0
        ) {
            FlashMessage::make()->success(
                message: __("You cant invite this player because you have been invited to a match in this time")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' =>  __("You cant invite this player because you have been invited to a match in this time"),
            ]);
        }
        // check if player because he has an hires at the same time
        if (
            $request->user()->hires()
            ->where('date', '!=', $date)
            ->whereRaw('DATE_ADD(`date`, INTERVAL 2 HOUR) > ?', [$date])
            ->whereRaw('DATE_SUB(`date`, INTERVAL 2 HOUR) < ?', [$date])
            ->where('state', 'accepted')
            ->get()->count() > 0
        ) {
            FlashMessage::make()->success(
                message: __("You cant invite this player because you have been invited to a match in this time")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' =>  __("You cant invite this player because you have been invited to a match in this time"),
            ]);
        }
        $date = Carbon::parse($data['date'])->setTime($time->hour, $time->minute);
        // check if player because he has an invitation at the same time
        if (
            $invitedPlayer->invitations()
            ->where('date', '!=', $date)
            ->whereRaw('DATE_ADD(`date`, INTERVAL 2 HOUR) > ?', [$date])
            ->whereRaw('DATE_SUB(`date`, INTERVAL 2 HOUR) < ?', [$date])
            ->where('state', 'accepted')
            ->get()->count() > 0
        ) {
            FlashMessage::make()->success(
                message: __("You cant invite this player because you have been invited to a match in this time")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' =>  __("You cant invite this player because you have been invited to a match in this time"),
            ]);
        }
        // check if player because he has an hires at the same time
        if (
            $invitedPlayer->hires()
            ->where('date', '!=', $date)
            ->whereRaw('DATE_ADD(`date`, INTERVAL 2 HOUR) > ?', [$date])
            ->whereRaw('DATE_SUB(`date`, INTERVAL 2 HOUR) < ?', [$date])
            ->where('state', 'accepted')
            ->get()->count() > 0
        ) {
            FlashMessage::make()->success(
                message: __("You cant invite this player because he has a match at the same time")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You cant invite this player because he has a match at the same time"),
            ]);
        }
        //check if user has Approved Invitations With Different Stadium And Same Time
        if (
            $request->user()
            ->hasApprovedInvitationsWithDifferentStadiumAndSameTime(
                CarbonImmutable::parse($data['date'])->setTime($time->hour, $time->minute),
                $request->input('stadium_id')
            )
        ) {
            FlashMessage::make()->success(
                message: __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium ")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium "),
            ]);
        }
        //check if user has Approved hires Invitations With Different Stadium And Same Time
        if (
            $request->user()
            ->hasApprovedHiresWithDifferentStadiumAndSameTime(
                CarbonImmutable::parse($data['date'])->setTime($time->hour, $time->minute),
                $request->input('stadium_id')
            )
        ) {
            FlashMessage::make()->success(
                message: __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium ")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium "),
            ]);
        }
        //check if invited Player has Approved  Invitations With Different Stadium And Same Time
        if (
            $invitedPlayer
            ->hasApprovedInvitationsWithDifferentStadiumAndSameTime(
                CarbonImmutable::parse($data['date'])->setTime($time->hour, $time->minute),
                $request->input('stadium_id')
            )
        ) {
            FlashMessage::make()->success(
                message: __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium ")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium "),
            ]);
        }
        //check if invited Player has Approved hires Invitations With Different Stadium And Same Time

        if (
            $invitedPlayer
            ->hasApprovedHiresWithDifferentStadiumAndSameTime(
                CarbonImmutable::parse($data['date'])->setTime($time->hour, $time->minute),
                $request->input('stadium_id')
            )
        ) {
            FlashMessage::make()->success(
                message: __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium ")
            )->closeable()->send();

            return redirect()->back()->withErrors([
                'invitation_error' => __("You have sent an invitation in the same time to in another staduim please choose another time or same the stadium "),
            ]);
        }
        $data['date'] = $data['date']->toString();


        $invitation = Invitation::create($data);
        // Notify the invited user
        $invitation->invitedPlayer->notify(new InvitationCreatedNotification($invitation));

        return redirect()->route('home');
    }
}
