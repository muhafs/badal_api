<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function country()
    {
        return $this->belongsTo(Country::class);
    }

    function offers()
    {
        return $this->hasMany(Seeker::class);
    }
}
