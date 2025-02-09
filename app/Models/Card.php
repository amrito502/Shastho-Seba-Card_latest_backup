<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'type',
        'price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isAssignedToCurrentUser(): bool
    {
        return $this->user_id === Auth::id();
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
