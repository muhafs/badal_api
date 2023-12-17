<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function phone_code()
    {
        return $this->belongsTo(Phone::class, "phone_code_id");
    }
}
