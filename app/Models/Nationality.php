<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nationality extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function country()
    {
        return $this->belongsTo(Country::class);
    }

    function users()
    {
        return $this->hasMany(User::class);
    }
}
