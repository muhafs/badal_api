<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function nationality()
    {
        return $this->hasOne(Nationality::class);
    }

    function currency()
    {
        return $this->hasOne(Currency::class);
    }

    function phone()
    {
        return $this->hasOne(Phone::class);
    }

    function provinces()
    {
        return $this->hasMany(Province::class);
    }
}
