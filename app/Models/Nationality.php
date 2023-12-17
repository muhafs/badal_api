<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    function users()
    {
        return $this->hasMany(User::class, 'nationality_id');
    }
}
