<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Panel extends Model
{
    protected $fillable = ['name', 'serial_number', 'power_capacity', 'status', 'user_id', 'zone_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function zone() {
        return $this->belongsTo(Zone::class);
    }

    public function energyData() {
        return $this->hasMany(EnergyData::class);
    }
}

