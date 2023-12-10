<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id'];

    function address()
    {
        return $this->belongsTo(Address::class, 'address');
    }

    function contact()
    {
        return $this->hasOne(Contact::class, 'user');
    }

    function getImageURL()
    {
        return $this->image_porfile ? url('storage/user/' . $this->image_porfile) : url('storage/default.png');
    }
}
