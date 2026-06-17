<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnergyData extends Model
{
protected $fillable = [
    'panel_id',
    'power',
    'consumption',
    'voltage',
    'current',
    'energy_kwh',
];   
    public function panel() {
        return $this->belongsTo(Panel::class);
    }
}

