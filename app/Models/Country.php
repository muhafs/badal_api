<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function provinces()
    {
        return $this->hasMany(Province::class, 'country_id');
    }

    function users()
    {
        return $this->hasMany(User::class, 'nationality_id');
    }
}
