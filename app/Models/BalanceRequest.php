<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceRequest extends Model
{
    protected $fillable = ['admin_id', 'amount', 'status', 'approved_by'];



    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function superadmin()
    {
        return $this->belongsTo(User::class, 'superadmin_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
