<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
// app/Models/Report.php
protected $fillable = ['user_id', 'total_energy', 'date_from', 'date_to', 'period_days'];
    public function user() {
        return $this->belongsTo(User::class);
    }
}

