<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * الحقول المخفية
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * العلاقات
     */
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function panels()
    {
        return $this->hasMany(Panel::class);
    }

    /**
     * Vonage phone routing (مهم جداً SMS)
     */
    public function routeNotificationForVonage($notification)
    {
        return $this->phone_number;
    }
}