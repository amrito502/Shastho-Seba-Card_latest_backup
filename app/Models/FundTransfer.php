<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class FundTransfer extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'amount',
        'transaction_id',
        'admin_id',
        'superadmin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isAssignedToCurrentUser(): bool
    {
        return $this->user_id === Auth::id();
    }

    public function superadmin()
    {
        return $this->belongsTo(User::class, 'superadmin_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->transaction_id = self::generateTransactionId();
        });
    }

    public static function generateTransactionId(): string
    {
        $prefix = 'TrxID';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix . $randomString;
    }
}
