<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'route_name',
        'ip_address',
        'user_agent',
    ];
}
