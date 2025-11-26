<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'accreditation_start_time',
        'accreditation_end_time',
    ];

    protected $casts = [
        'accreditation_start_time' => 'datetime',
        'accreditation_end_time' => 'datetime',
    ];

    /**
     * Check if accreditation is currently active
     */
    public static function isAccreditationActive(): bool
    {
        $setting = self::first();

        if (!$setting || !$setting->accreditation_start_time || !$setting->accreditation_end_time) {
            return true; // If no settings, allow accreditation
        }

        $now = now();
        return $now->between($setting->accreditation_start_time, $setting->accreditation_end_time);
    }

    /**
     * Get the accreditation status message
     */
    public static function getAccreditationStatusMessage(): ?string
    {
        $setting = self::first();

        if (!$setting || !$setting->accreditation_start_time || !$setting->accreditation_end_time) {
            return null;
        }

        $now = now();

        if ($now->lt($setting->accreditation_start_time)) {
            return 'Accreditation has not started yet. It will begin on ' .
                   $setting->accreditation_start_time->format('F j, Y \a\t g:i A');
        }

        if ($now->gt($setting->accreditation_end_time)) {
            return 'Accreditation period has ended. It ended on ' .
                   $setting->accreditation_end_time->format('F j, Y \a\t g:i A');
        }

        return null;
    }
}
