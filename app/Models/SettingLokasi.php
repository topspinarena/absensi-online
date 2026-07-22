<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingLokasi extends Model
{
    protected $table = 'setting_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius'
    ];
}