<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'other_name',
        'email',
        'phone_number',
        'staff_ID',
        'grade',
        'photo'
    ];

    public function accreditations()
    {
        return $this->hasMany(accreditation::class);
    }

    public function votes()
    {
        return $this->hasMany(vote::class);
    }
}
