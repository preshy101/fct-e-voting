<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class election extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'start_date',
        'end_date',
        'is_active',
        'slug',
        'election_rules'
    ];

    protected $casts = [
        'election_rules' => 'array',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function electionCandidates()
    {
        return $this->hasMany(electionCandidate::class);
    }

    public function candidates2()
    {
        return $this->belongsToMany(candidate::class);
    }

    public function candidates()
    {
        return $this->belongsToMany(candidate::class, 'candidate_election');
    }

    public function accreditations()
    {
        return $this->hasMany(accreditation::class);
    }

    public function votes()
    {
        return $this->hasMany(vote::class);
    }
}
