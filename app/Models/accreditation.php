<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class accreditation extends Model
{
    protected $fillable = [
        'member_id',
        'election_id',
        'token',
        'is_approved',
        'is_used',
        'used_at',
        'image',
        'note',
        'type'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_used' => 'boolean',
        'used_at' => 'datetime'
    ];

    public function election()
    {
        return $this->belongsTo(election::class);
    }

    public function member()
    {
        return $this->belongsTo(member::class);
    }

    public function votes()
    {
        return $this->hasMany(vote::class);
    }
}
