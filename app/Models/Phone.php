<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Phone extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function country()
    {
        return $this->belongsTo(Country::class);
    }

    function contacts()
    {
        return $this->hasMany(Contact::class, "phone_code_id");
    }
}
