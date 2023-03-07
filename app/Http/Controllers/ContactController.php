<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\AdminCreatedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        Admin::all()->each(function (Admin $admin) use ($contact) {
            if ($admin->hasPermissionTo('receive contact notification')) {
                $admin->notify(new AdminCreatedNotification($contact));
            }
        });
    }
}
