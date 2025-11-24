<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class candidate extends Model
{
    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function candidateBio()
    {
        return $this->hasOne(candidateBio::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function elections()
    {
        return $this->belongsToMany(election::class, 'candidate_election');
    }

    public function votes()
    {
        return $this->hasMany(\App\Models\vote::class);
    }
}
