<?php

namespace App\Http\Controllers;

use App\Models\election;
use App\Models\vote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{
    public function index()
    {
        $elections = election::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
        return view('welcome', compact('elections'));
    }
    public function verify(Request $request)
{
    dd($request->all());
    $validated = $request->validate([
        'practice_id' => 'required',
        'voter_id' => 'required',
        'election_slug' => 'required|exists:elections,slug'
    ]);

    // Verify the practice ID and voter ID
    // If valid, redirect to voting page
    // If invalid, redirect back with errors
}
    public function elections($slug)
    {
        // Fetch election details using the slug
        if ($slug == 'all') {
            $elections = \App\Models\election::with('candidates')
            ->where([['is_active', true], ['start_date', '<=', now()], ['end_date', '>=', now()]])
            ->get();

            return view('election.details', compact('elections'));
        }else{

        $elections = \App\Models\election::with('candidates')
        // ->where(['is_active' => true, 'start_date' => ['<=', now()], 'end_date' => ['>=', now()]])
        ->where('id',$slug)->get();

        // Return a view with election details
        return view('election.details', compact('elections'));
        }
        return redirect()->back();
    }

    public function cast(Request $request)
    {
        $validated = $request->validate([
            'election_id' => 'required|exists:elections,id',
            'candidate_id' => 'required|exists:candidates,id',
            'member_id' => 'required|exists:members,id',
            'token' => 'required|string'
        ]);

        try {
            // Verify accreditation token
            $accreditation = \App\Models\accreditation::where('token', strtoupper($request->token))
                ->where('member_id', $request->member_id)
                ->where('is_used', false)
                ->first();

            if (!$accreditation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or already used accreditation token.'
                ], 422);
            }

            // Get election details
            $election = election::with('candidates')
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->findOrFail($request->election_id);

            // Check if voter has already voted in this election
            $hasVoted = vote::where('election_id', $request->election_id)
                ->where('member_id', $request->member_id)
                ->exists();

            if ($hasVoted) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already voted in this election.'
                ], 422);
            }

            // Get member and candidate details
            $member = \App\Models\Member::findOrFail($request->member_id);
            $candidate = \App\Models\candidate::findOrFail($request->candidate_id);

            // Create vote token
            $voteToken = Str::upper(Str::random(8));

            // Create the vote
            $voteCast = vote::create([
                'election_id' => $request->election_id,
                'candidate_id' => $request->candidate_id,
                'member_id' => $request->member_id,
                'accreditation_id' => $accreditation->id,
                'token' => $voteToken,
            ]);

            // Mark accreditation token as used
            $accreditation->update([
                'is_used' => true,
                'used_at' => now()
            ]);

            // Prepare vote data for email
            $voteData = [
                'election_id' => $election->id,
                'election_title' => $election->title,
                'candidate_name' => $candidate->full_name,
                'vote_token' => $voteToken
            ];

            // Send confirmation email
            try {
                if ($member->email) {
                    Mail::to($member->email)->send(new \App\Mail\VoteConfirmation($member, [$voteData]));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send vote confirmation email: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Your vote has been successfully submitted.',
                'redirect_url' => route('vote.single.success', [
                    'vote' => base64_encode(json_encode($voteData)),
                    'member_email' => $member->email,
                    'allow_result_preview' => $election->allow_result_preview ?? false
                ])
            ]);

        } catch (\Exception $e) {
            Log::error('Vote submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your vote. Please try again.'
            ], 500);
        }
    }

    private function verifyPracticeId($practiceId, $voterId)
    {
        // Add your practice ID verification logic here
        // Return true if valid, false if invalid
    }

    public function showSuccess(Request $request)
        {
            $vote = Vote::with('election')->findOrFail($request->vote_id);

            return view('election.success', [
                'election' => $vote->election,
                'vote_reference' => $vote->reference_id // or however you're storing the reference
            ]);
        }

    public function verifyPractice(Request $request)
    {
        $request->validate([
            'practice_id' => 'required|exists:members,practice_ID',
        ]);

        $member = \App\Models\Member::where('practice_ID', $request->practice_id)->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Practice ID. Please check and try again.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'member_id' => $member->id,
            'name' => $member->first_name . ' ' . $member->last_name,
        ]);
    }

    public function results($id)
        {
            $election = \App\Models\election::where('id', $id)
                ->with(['candidates' => function ($q) {
                    $q->withCount('votes');
                }])
                ->firstOrFail();
            $membersCount = \App\Models\member::count();

            return view('election.result', compact('election', 'membersCount'));
        }

    /**
     * Show all active elections for voting
     */
    public function allElections()
    {
        $elections = election::with('candidates.candidateBio')
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('election.all', compact('elections'));
    }

    /**
     * Submit votes for multiple elections
     */
    public function submitAllVotes(Request $request)
    {
        $request->validate([
            'votes' => 'required|array',
            'votes.*' => 'required|exists:candidates,id',
            'member_id' => 'required|exists:members,id',
            'token' => 'required|string'
        ]);

        try {
            // Verify accreditation token
            $accreditation = \App\Models\accreditation::where('token', strtoupper($request->token))
                ->where('member_id', $request->member_id)
                ->where('is_used', false)
                ->first();

            if (!$accreditation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or already used accreditation token.'
                ], 422);
            }

            $member = \App\Models\Member::findOrFail($request->member_id);
            $votesData = [];

            foreach ($request->votes as $electionId => $candidateId) {
                // Check if already voted in this election
                $hasVoted = vote::where('election_id', $electionId)
                    ->where('member_id', $request->member_id)
                    ->exists();

                if ($hasVoted) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already voted in one or more of these elections.'
                    ], 422);
                }

                // Create vote record
                $voteToken = Str::upper(Str::random(8));
                $vote = vote::create([
                    'election_id' => $electionId,
                    'candidate_id' => $candidateId,
                    'member_id' => $request->member_id,
                    'accreditation_id' => $accreditation->id,
                    'token' => $voteToken,
                ]);

                // Get election and candidate details for email
                $election = election::find($electionId);
                $candidate = \App\Models\candidate::find($candidateId);

                $votesData[] = [
                    'election_id' => $electionId,
                    'election_title' => $election->title,
                    'candidate_name' => $candidate->full_name,
                    'vote_token' => $voteToken
                ];
            }

            // Mark accreditation token as used
            $accreditation->update([
                'is_used' => true,
                'used_at' => now()
            ]);

            // Send confirmation email
            try {
                if ($member->email) {
                    Mail::to($member->email)->send(new \App\Mail\VoteConfirmation($member, $votesData));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send vote confirmation email: ' . $e->getMessage());
            }

            // Get first election for result preview check
            $firstElection = election::find(array_key_first($request->votes));

            return response()->json([
                'success' => true,
                'message' => 'Your votes have been successfully submitted.',
                'redirect_url' => route('vote.all.success', [
                    'votes' => base64_encode(json_encode($votesData)),
                    'member_email' => $member->email,
                    'allow_result_preview' => $firstElection->allow_result_preview ?? false
                ])
            ]);

        } catch (\Exception $e) {
            Log::error('Vote submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your votes. Please try again.'
            ], 500);
        }
    }

    /**
     * Show success page for bulk votes
     */
    public function showAllVotesSuccess(Request $request)
    {
        $votesData = json_decode(base64_decode($request->votes), true);

        return view('election.vote-success', [
            'votes' => $votesData,
            'votesCount' => count($votesData),
            'memberEmail' => $request->member_email,
            'allowResultPreview' => $request->allow_result_preview ?? false
        ]);
    }

    /**
     * Show success page for single vote
     */
    public function showSingleVoteSuccess(Request $request)
    {
        $voteData = json_decode(base64_decode($request->vote), true);

        return view('election.vote-success', [
            'votes' => [$voteData],
            'votesCount' => 1,
            'memberEmail' => $request->member_email,
            'allowResultPreview' => $request->allow_result_preview ?? false
        ]);
    }

}
