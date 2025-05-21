<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{

    public function index(Request $request)
    {
 
        $category = $request->category_id;
 
        if ($category != 0 ) {
            $challenges = Category::where('id', $request->category_id)->firstOrFail()->challenges;
            $category = Category::where('id', $request->category_id)->firstOrFail()->name;
          
        } else {
            $challenges = Challenge::all();
            $category= 'Guztiak';
        }

        return view('challenges.index', compact('challenges', 'category'));
    }

    public function show(Challenge $challenge)
    {


         $challenge->load(['users' => function ($query) {
             $query->withPivot('status', 'completed_at');
         }]);
     
        return view('challenges.show', compact('challenge'));
    }

    public function join(Challenge $challenge)
    {
        $user = Auth::user();
    
        if (!$challenge->users->contains($user)) {
            $challenge->users()->attach($user->id, ['status' => 'pendiente']);
        }
    
        return back()->with('success', 'Erronkan apuntatuta zaude jada.');
    }
    

}
