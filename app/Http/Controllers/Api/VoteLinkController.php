<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendVoteLink;
use App\Models\election;
use App\Models\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class VoteLinkController extends Controller
{
    public function sendLink(Request $request)
    {
        // 1. Validate the incoming request
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|string|exists:members,staff_id',
            'election_id' => 'required|string|exists:elections,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid Practice ID'], 422);
        }

        // 2. Find the voter
        $voter = member::where('staff_ID', $request->staff_ID)->first();
        //3. check election settings
        $setting = election::find($request->election_id);
        if($setting && !$setting->is_active){
            return response()->json(['message' => 'Election is not active'], 403);
        }

        if (!$voter) {
            // We use a generic message for security
            return response()->json(['message' => 'If this ID is valid, an email is on its way.'], 200);
        }

        // 3. Generate the secure, temporary signed URL
        // This link will be valid for 30 minutes (you can change this)
        $signedUrl = URL::temporarySignedRoute(
            'vote.page', // The name of our web route
            now()->addMinutes(30),
            ['voter' => $voter->id] // Pass the voter's ID
        );

        // 4. Send the email
        try {
            Mail::to($voter->email)->send(new SendVoteLink($signedUrl));
        } catch (\Exception $e) {
            // Handle mail sending errors
            return response()->json(['message' => 'Could not send email. Please try again later.'], 500);
        }

        return response()->json(['message' => 'If this ID is valid, an email is on its way.'], 200);
    }

    /**
     * Shows the actual voting page after the link is clicked.
     */
    public function showVotingPage(Request $request, member $voter)
    {
        // Because of the 'signed' middleware on the route,
        // we know this request is valid and not tampered with.

        // Now, you can show the voting page.
        // You might want to log the user in or create a temporary session
        // auth()->login($voter); // If you have a User model, not a Voter model

        return view('voting-page', [
            'voter' => $voter,
            'electionCategory' => $request->query('category') // You could pass this in the signed URL too!
        ]);
    }
}
