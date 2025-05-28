<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Badge;


class UserController extends Controller
{
 
    public function userChallenges(User $user){
        // Obtener los retos del usuario con la información de la tabla pivot
        $challenges = $user->challenges()->withPivot('status', 'proof', 'completed_at')->get();
        $badges = $user->badges;

        return view('user.challenges', compact('user', 'challenges', 'badges'));
    }


    private function checkForBadges(User $user)
    {
        // Erabiltzaileak osatutako erronka-kopurua lortzea
        $completedChallenges = $user->challenges()->wherePivot('status', 'completado')->count();

        // Eskakizunen araberako bereizgarriak esleitzea

        if ($completedChallenges >= 2) {
            $badge = Badge::where('name', '2 erronka osatu')->first();
            $user->badges()->syncWithoutDetaching([$badge->id]);
        }

        if ($completedChallenges >= 5) {
            $badge = Badge::where('name', '5 erronka osatu')->first();
            $user->badges()->syncWithoutDetaching([$badge->id]);
        }

        if ($completedChallenges >= 10) {
            $badge = Badge::where('name', '10 erronka osatu')->first();
            $user->badges()->syncWithoutDetaching([$badge->id]);
        }
    }


    public function updateChallengeStatus(Request $request, User $user, Challenge $challenge){
        $request->validate([
            'status' => 'required|in:completado,fallido',
        ]);

        if ($request->status === 'completado'){
            $completedAt = now();  // Momentu honetako data eta ordua jarriko dugu
        }else{
            $completedAt = null;
        }

        $user->challenges()->updateExistingPivot($challenge->id, [
            'status' => $request->status,
            'completed_at' => $completedAt
        ]);

        if ($request->status === 'completado'){   // Behin datua aldatuta dagoenean, insignia berriak begiratu
           $this->checkForBadges($user);
        }

        return redirect()->back()->with('success', 'Status-a ondo aldatu da.');
    }

}
