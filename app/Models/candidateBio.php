<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class candidateBio extends Model
{
    public function candidateBio()
    {
        return $this->belongsTo(candidate::class);
    }
}
