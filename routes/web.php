<?php

use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/election', [VoteController::class, 'index'])->name('election');
Route::get('/election/all', [VoteController::class, 'allElections'])->name('election.all');
Route::post('/election/all/submit', [VoteController::class, 'submitAllVotes'])->name('election.all.submit');
Route::get('/election/all/success', [VoteController::class, 'showAllVotesSuccess'])->name('vote.all.success');
Route::get('/election/{slug}', [VoteController::class, 'elections'])->name('election.view');
Route::get('/election/{slug}/preview', [VoteController::class, 'preview'])->name('election.preview');
Route::post('/election/vote/cast', [VoteController::class, 'cast'])->name('election.vote.cast');
Route::get('/election/vote/success', [VoteController::class, 'showSingleVoteSuccess'])->name('vote.single.success');
Route::get('/election/{id}/result', [VoteController::class, 'results'])->name('election.result');

// Real-time live results preview across all active elections
Route::get('/results', [VoteController::class, 'liveResults'])->name('election.live.results');
Route::get('/election/live-results', [VoteController::class, 'liveResults']);

Route::post('/verify-practice', [VoteController::class, 'verifyPractice'])->name('verify.practice');

// Accreditation routes
Route::get('/accreditation', [AccreditationController::class, 'index'])->name('accreditation.index');
Route::post('/accreditation/request', [AccreditationController::class, 'request'])->name('accreditation.request');
Route::post('/accreditation/verify', [AccreditationController::class, 'verify'])->name('accreditation.verify');
Route::post('/accreditation/{id}/approve', [AccreditationController::class, 'approve'])->name('accreditation.approve');
Route::post('/accreditation/{id}/reject', [AccreditationController::class, 'reject'])->name('accreditation.reject');
