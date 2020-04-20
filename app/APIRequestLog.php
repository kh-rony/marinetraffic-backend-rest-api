<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APIRequestLog extends Model
{
    protected $table = 'api_request_logs';
    protected $fillable = [
        'ip',
        'url',
        'request'
    ];
}
