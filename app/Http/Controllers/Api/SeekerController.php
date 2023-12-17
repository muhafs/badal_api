<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Seeker;
use App\Models\Address;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Seeker\SeekerResource;
use App\Http\Requests\Seeker\GetSeekerRequest;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Requests\Seeker\UpdateSeekerRequest;
use App\Http\Resources\Seeker\SeekerListResource;

class SeekerController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $seekers = SeekerListResource::collection(Seeker::available()->with('user')->get());

        return $this->jsonResponse("Success", $seekers);
    }

    function show(GetSeekerRequest $request)
    {
        $seeker = new SeekerResource(Seeker::with('user')->find($request->id));

        if (!$seeker->available) {
            $this->throwResponse('This Seeker not Available.', 404);
        }

        return $this->jsonResponse("Success", $seeker);
    }

    function store(StoreSeekerRequest $request)
    {
        $user = User::create([
            'type' => 'SKR',
            'first_name' => str($request->first_name)->ucfirst()->trim(),
            'last_name' => str($request->last_name)->trim()->isEmpty() ? null : str($request->last_name)->ucfirst()->trim(),
            'gender' => str($request->gender)->upper()->trim(),
            "birth_date" => Carbon::make($request->birth_date)->toDateString(),
            'image_porfile' => $imageName ?? null,
            'nationality_id' => $request->nationality_id,
        ]);

        if (!$user) {
            $this->throwResponse("Something went Error while Creating Seeker User");
        }

        $seeker = Seeker::create([
            'user_id' => $user->id,
            'hajj_name' => str($request->hajj_name)->trim()->isEmpty() ? null : str($request->hajj_name)->title()->squish(),
            'currency' => str($request->currency)->upper()->trim(),
            'price' => $request->price,
        ]);

        if (!$seeker) {
            $this->throwResponse("Something went Error while Creating Seeker");
        }

        $contact = Contact::create([
            'user_id' => $user->id,
            'email' => $request->email ?? null,
            'phone_code' => str($request->phone_code)->trim(),
            'phone_number' => str($request->phone_number)->trim(),
            'whatsapp' => str($request->whatsapp)->trim()->isEmpty() ? null : str($request->whatsapp)->trim(),
            'instagram' => str($request->instagram)->trim()->isEmpty() ? null : str($request->instagram)->lower()->trim(),
            'facebook' => str($request->facebook)->trim()->isEmpty() ? null : str($request->facebook)->squish()
        ]);

        if (!$contact) {
            $this->throwResponse("Something went Error while Creating Seeker Contact");
        }

        $address = Address::create([
            'user_id' => $user->id,
            'address' => str($request->address)->title()->squish(),
            'postcode' => str($request->postcode)->upper()->trim(),
            'city_id' => $request->city_id,
        ]);

        if (!$address) {
            $this->throwResponse("Something went Error while Creating Seeker Address");
        }

        return $this->jsonResponse("Success Create Seeker", $seeker, 201);
    }

    //TODO: has to be done
    // function update(UpdateSeekerRequest $request)
    // {
    //     $seeker = Seeker::find($request->id);

    //     $seeker->update([
    //         'name' => str($request->name ?? $seeker->name)->title()->squish(),
    //         'country_id' => $request->country_id ?? $seeker->country_id
    //     ]);

    //     if (!$seeker) {
    //         $this->throwResponse("Something went Error while Updating Seeker");
    //     }

    //     return $this->jsonResponse("Success Update Seeker", $seeker, 201);
    // }

    function destroy(GetSeekerRequest $request)
    {
        $seeker = Seeker::find($request->id);

        $seeker->user->delete();

        if (!$seeker) {
            $this->throwResponse("Something went Error while Deleting Seeker");
        }

        return $this->jsonResponse("Success Delete Seeker", $seeker, 201);
    }
}
