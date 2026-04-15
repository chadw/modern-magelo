<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'key',
        'name',
        'requests',
        'last_used_at'
    ];
}
