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
        return $this->belongsTo(Nationality::class);
    }

    function address()
    {
        return $this->hasOne(Address::class);
    }

    function contact()
    {
        return $this->hasOne(Contact::class);
    }

    function seeker()
    {
        return $this->hasOne(Seeker::class);
    }

    function performer()
    {
        return $this->hasOne(Performer::class);
    }

    // Methods
    function getImageURL()
    {
        return $this->image_porfile ? url('storage/user/' . $this->image_porfile) : url('storage/default.png');
    }
}
