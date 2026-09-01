<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class SmsService
{
    /**
     * Send accreditation token via Twilio SMS
     */
    public static function sendToken(?string $phoneNumber, ?string $firstName, string $token): bool
    {
        if (!$phoneNumber) {
            Log::warning('Member has no phone number. SMS not sent.');
            return false;
        }

        $sid = config('services.twilio.sid') ?: env('TWILIO_SID');
        $authToken = config('services.twilio.token') ?: env('TWILIO_AUTH_TOKEN');
        $fromNumber = config('services.twilio.from') ?: env('TWILIO_PHONE_NUMBER');

        if (!$sid || !$authToken || !$fromNumber) {
            Log::warning('Twilio credentials not configured. SMS not sent.');
            return false;
        }

        $formattedPhone = self::formatPhoneNumber($phoneNumber);

        try {
            $client = new Client($sid, $authToken);
            $message = $client->messages->create(
                $formattedPhone,
                [
                    'from' => $fromNumber,
                    'body' => "Hello " . ($firstName ?: 'Member') . ", your accreditation token is: {$token}. Use this to cast your vote securely on the E-Voting portal."
                ]
            );

            Log::info("Accreditation SMS sent successfully to {$formattedPhone}. SID: {$message->sid}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send Twilio SMS to {$formattedPhone}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Format phone number to E.164 format
     */
    public static function formatPhoneNumber(string $phone): string
    {
        $phone = trim($phone);
        // Remove spaces, dashes, dots, and parentheses
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // If local Nigerian format (e.g. 080..., 070..., 090..., 081...)
        if (preg_match('/^0([789][01]\d{8})$/', $phone, $matches)) {
            return '+234' . $matches[1];
        }

        // If starts with 234 without +
        if (str_starts_with($phone, '234')) {
            return '+' . $phone;
        }

        // If already starts with +
        if (str_starts_with($phone, '+')) {
            return $phone;
        }

        return '+' . $phone;
    }
}
