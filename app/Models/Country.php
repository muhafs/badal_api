<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function addresses()
    {
        return $this->hasMany(Address::class, 'country');
    }

    function users()
    {
        return $this->hasMany(User::class, 'nationality');
    }
}
