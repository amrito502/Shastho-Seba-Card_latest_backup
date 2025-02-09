<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'superadmin_id',
        'admin_id',
        'cards'
    ];

    protected $casts = [
        'cards' => 'array', // Cast JSON to array
    ];

    public function superadmin()
    {
        return $this->belongsTo(User::class, 'superadmin_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
