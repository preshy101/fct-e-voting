<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'election_id',
        'accreditation_start_time',
        'accreditation_end_time',
    ];

    protected $casts = [
        'accreditation_start_time' => 'datetime',
        'accreditation_end_time' => 'datetime',
    ];

    /**
     * Relationship to the election this accreditation setting belongs to
     */
    public function election()
    {
        return $this->belongsTo(election::class);
    }

    /**
     * Check if accreditation is currently active for a specific election or generally
     */
    public static function isAccreditationActive(?int $electionId = null): bool
    {
        if ($electionId) {
            $setting = self::where('election_id', $electionId)->first();
            if ($setting && $setting->accreditation_start_time && $setting->accreditation_end_time) {
                return now()->between($setting->accreditation_start_time, $setting->accreditation_end_time);
            }
        }

        // Check if there are election-specific settings active right now
        $hasActiveElectionSettings = self::whereNotNull('election_id')
            ->whereNotNull('accreditation_start_time')
            ->whereNotNull('accreditation_end_time')
            ->where('accreditation_start_time', '<=', now())
            ->where('accreditation_end_time', '>=', now())
            ->exists();

        if ($hasActiveElectionSettings) {
            return true;
        }

        // Check global fallback setting (without election_id)
        $globalSetting = self::whereNull('election_id')->first();
        if ($globalSetting && $globalSetting->accreditation_start_time && $globalSetting->accreditation_end_time) {
            return now()->between($globalSetting->accreditation_start_time, $globalSetting->accreditation_end_time);
        }

        // If no settings exist at all, allow accreditation
        if (self::count() === 0) {
            return true;
        }

        return false;
    }

    /**
     * Get the accreditation status message
     */
    public static function getAccreditationStatusMessage(?int $electionId = null): ?string
    {
        $setting = null;
        if ($electionId) {
            $setting = self::where('election_id', $electionId)->first();
        }

        if (!$setting) {
            $setting = self::whereNull('election_id')->first() ?? self::orderBy('accreditation_start_time', 'desc')->first();
        }

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
