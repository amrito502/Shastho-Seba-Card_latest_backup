<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LoadMoney extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'amount',
        'user_id',
        'superadmin_id',
    ];

    public function superadmin()
    {
        return $this->belongsTo(User::class, 'superadmin_id');
    }


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
}
