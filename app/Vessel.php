<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    protected $table = 'vessels';
    public $timestamps = false;
    protected $fillable = [
        'mmsi',
        'status',
        'stationId',
        'speed',
        'lat',
        'lon',
        'course',
        'heading',
        'rot',
        'timestamp'
    ];
}
