<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['contact', 'address'];

    // Relationship
    function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }

    function contact()
    {
        return $this->hasOne(Contact::class, 'user_id');
    }

    function seeker()
    {
        return $this->hasOne(Seeker::class, 'user_id');
    }

    function performer()
    {
        return $this->hasOne(Performer::class, 'user_id');
    }

    // Methods
    function getImageURL()
    {
        return $this->image_porfile ? url('storage/user/' . $this->image_porfile) : url('storage/default.png');
    }
}
