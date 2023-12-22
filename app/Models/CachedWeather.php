<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CachedWeather extends Model
{
    use HasFactory;

    protected $table = 'cached_weathers';

    protected $fillable = ['city_name', 'weather_data'];
}
