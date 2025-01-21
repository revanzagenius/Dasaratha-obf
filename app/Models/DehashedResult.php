<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DehashedResult extends Model
{
    protected $table = 'dehashed_results';  // Tentukan nama tabel jika diperlukan
    protected $fillable = [
        'domain',
        'username',
        'email',
        'password',
        'status',
        'last_scanned_at',
    ];
}
