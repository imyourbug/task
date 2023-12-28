<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_task',
        'name',
        'password',
        'cod',
        'receiver',
        'phone_receiver',
        'phone_otp',
        'address',
        'ward',
        'district',
        'province',
        'link',
        'code',
        'wage',
        'status',
        'user_id',
        'is_display_otp',
        'otp',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
