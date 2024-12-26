<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DehashedResult extends Model
{
    protected $fillable = [
        'domain',
        'username',
        'email',
        'password',
    ];
}
