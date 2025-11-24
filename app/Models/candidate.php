<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class candidate extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function candidateBio()
    {
        return $this->hasOne(CandidateBio::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function elections()
    {
        return $this->belongsToMany(Election::class, 'candidate_election');
    }

    public function votes()
    {
        return $this->hasMany(\App\Models\Vote::class);
    }
}
