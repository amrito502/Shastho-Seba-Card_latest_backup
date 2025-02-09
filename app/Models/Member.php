<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fatherName',
        'motherName',
        'dob',
        'nid',
        'gender',
        'religion',
        'mobile',
        'member_photo',
        'age',
        'address',
        'family_members',

        'district_id',
        'sub_district_id',
        'card_id',
        'admin_id',
    ];

    protected $casts = [
        'family_members' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
