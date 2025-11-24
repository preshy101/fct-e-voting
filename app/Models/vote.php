<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    protected $fillable = ['election_id', 'member_id', 'accreditation_id', 'candidate_id', 'token'];

    public function election()
    {
        return $this->belongsTo(election::class);
    }

    public function member()
    {
        return $this->belongsTo(member::class);
    }

    public function accreditation()
    {
        return $this->belongsTo(accreditation::class);
    }

    public function candidate()
    {
        return $this->belongsTo(candidate::class);
    }
    public function votes()
    {
        return $this->hasMany(\App\Models\Vote::class);
    }
}
