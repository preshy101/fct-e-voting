<?php

namespace App\Http\Controllers;

use App\Mail\AccreditationToken;
use App\Models\accreditation;
use App\Models\election;
use App\Models\member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AccreditationController extends Controller
{
    /**
     * Display the accreditation request page
     */
    public function index()
    {
        $elections = election::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        $isAccreditationActive = Setting::isAccreditationActive();
        $accreditationMessage = Setting::getAccreditationStatusMessage();
        $setting = Setting::first();

        return view('accreditation.index', compact('elections', 'isAccreditationActive', 'accreditationMessage', 'setting'));
    }

    /**
     * Handle accreditation request submission
     */
    public function request(Request $request)
    {
        // Check if accreditation is active
        if (!Setting::isAccreditationActive()) {
            $message = Setting::getAccreditationStatusMessage();
            return back()->withErrors([
                'staff_id' => $message ?? 'Accreditation is currently not available.'
            ]);
        }

        $validated = $request->validate([
            'staff_id' => 'required|string',
        ]);

        $input = trim($request->staff_id);

        // Find the member by email address or staff ID
        $member = member::where('email', $input)
            ->orWhere('staff_ID', $input)
            ->first();

        if (!$member) {
            return back()->withErrors([
                'staff_id' => 'No registered member found with this Staff ID or Email Address.'
            ])->withInput();
        }

        // Check if already accredited and not used
        $existingAccreditation = accreditation::where('member_id', $member->id)
            ->where('is_used', false)
            ->first();

        if ($existingAccreditation) {
            // Return existing token if already generated
            return back()->with([
                'success' => 'Your accreditation token has already been generated.',
                'token' => $existingAccreditation->token,
                'member' => $member
            ]);
        }

        // Generate a unique token
        $token = Str::upper(Str::random(6));

        // Ensure token is unique
        while (accreditation::where('token', $token)->exists()) {
            $token = Str::upper(Str::random(6));
        }

        // Create accreditation record with token
        $accreditation = accreditation::create([
            'member_id' => $member->id,
            'token' => $token,
            'is_used' => false,
        ]);

        // Send email notification with token
        try {
            if ($member->email) {
                Mail::to($member->email)->send(new AccreditationToken($accreditation));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send accreditation email: ' . $e->getMessage());
        }

        // Return success with token for frontend display
        return back()->with([
            'success' => 'Your accreditation token has been generated successfully.' . ($member->email ? ' An email has been sent to your registered email address.' : ''),
            'token' => $accreditation->token,
            'member' => $member
        ]);
    }


    /**
     * Verify accreditation token for voting
     */
    public function verify(Request $request)
    {
        // Check if accreditation is active
        if (!Setting::isAccreditationActive()) {
            $message = Setting::getAccreditationStatusMessage();
            return response()->json([
                'success' => false,
                'message' => $message ?? 'Accreditation is currently not available.'
            ], 403);
        }

        $request->validate([
            'token' => 'required|string'
        ]);

        $accreditation = accreditation::where('token', strtoupper($request->token))
            ->where('is_used', false)
            ->with('member')
            ->first();

        if (!$accreditation) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or already used accreditation token.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'member_id' => $accreditation->member_id,
            'accreditation_id' => $accreditation->id,
            'member_email' => $accreditation->member->email
        ]);
    }
}
