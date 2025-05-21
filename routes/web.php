<?php

use App\Models\Challenge;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\UserController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->with('error', 'Emaila edo pasahitza okerrak dira.');
})->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


Route::get('/{category?}', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');
Route::post('/challenges/{challenge}/join', [ChallengeController::class, 'join'])
    ->middleware('auth')
    ->name('challenges.join');


Route::get('/user/challenges/{user}', [UserController::class, 'userChallenges'])->name('user.challenges');
Route::patch('/users/{user}/challenges/{challenge}/status', [UserController::class, 'updateChallengeStatus'])
    ->name('user.challengestatus');

