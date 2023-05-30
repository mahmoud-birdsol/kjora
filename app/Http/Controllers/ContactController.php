<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\ContactCreatedNotification;
use App\Services\FlashMessage;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        Admin::all()->each(function (Admin $admin) use ($contact) {
            if ($admin->hasPermissionTo('receive contact notification')) {
                $admin->notify(new ContactCreatedNotification($contact));
            }
        });

        FlashMessage::make()->success(
            message: __('Your contact request has reached us and we will review it shortly')
        )->closeable()->send();

        return redirect()->back();
    }
}
