<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Contact\ContactResource;
use App\Http\Requests\Contact\GetContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\Contact\ContactListResource;

class ContactController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $contacts = ContactListResource::collection(Contact::all());

        return $this->jsonResponse("Success", $contacts);
    }

    function show(GetContactRequest $request)
    {
        $contact = new ContactResource(Contact::find($request->id));

        return $this->jsonResponse("Success", $contact);
    }

    function store(StoreContactRequest $request)
    {
        $contact = Contact::create([
            "user_id" => $request->user_id,
            "phone_code_id" => $request->phone_code_id,
            "phone_number" => str($request->phone_number)->trim(),
            "email" => str($request->email)->trim(),
            "whatsapp" => str($request->whatsapp)->trim(),
            "instagram" => str($request->instagram)->lower()->trim(),
            "facebook" => str($request->facebook)->title()->squish()
        ]);

        if (!$contact) {
            $this->throwResponse("Something went Error while Creating Contact");
        }

        return $this->jsonResponse("Success Create Contact", $contact, 201);
    }

    function update(UpdateContactRequest $request)
    {
        $contact = Contact::find($request->id);

        $contact->update([
            "user_id" => $request->user_id,
            "phone_code_id" => $request->phone_code_id,
            "phone_number" => str($request->phone_number)->trim(),
            "email" => str($request->email)->trim(),
            "whatsapp" => str($request->whatsapp)->trim(),
            "instagram" => str($request->instagram)->lower()->trim(),
            "facebook" => str($request->facebook)->title()->squish()
        ]);

        if (!$contact) {
            $this->throwResponse("Something went Error while Updating Contact");
        }

        return $this->jsonResponse("Success Update Contact", $contact, 201);
    }

    function destroy(GetContactRequest $request)
    {
        $contact = Contact::destroy($request->id);

        if (!$contact) {
            $this->throwResponse("Something went Error while Deleting Contact");
        }

        return $this->jsonResponse("Success Delete Contact", $contact, 201);
    }
}
