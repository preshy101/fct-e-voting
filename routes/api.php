<?php

use App\Http\Controllers\Api\VoteLinkController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\election;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/request-vote-link', [VoteLinkController::class, 'sendLink']);
Route::get('/vote/verify', [VoteLinkController::class, 'showVotingPage'])
    ->name('vote.page')
    ->middleware('signed');

// Single election result api
Route::get('/elections/{id}/results', function ($id) {
    $election = election::with(['candidates' => fn($q) => $q->withCount('votes')])
        ->findOrFail($id);

    return response()->json($election->candidates->map(fn($c) => [
        'id' => $c->id,
        'name' => $c->first_name . ' ' . $c->last_name,
        'votes_count' => $c->votes_count,
    ]));
})->name('api.election.results');

// Real-time all active elections live results api
Route::get('/elections/live-results', [VoteController::class, 'apiAllLiveResults'])->name('api.elections.all.results');
