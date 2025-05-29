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

    public function userChallenges(User $user)
    {
        // Obtenemos los challenges a partir de la tabla intermedia de la relación n-m
        $challenges = $user->challenges()->withPivot('status', 'completed_at');//en withPivot indicamos que campos queremos aparte de id 

        // Aplica filtro si hay parámetro 'status' a los $challenges que mostraremos
        if (request('status')) {
            $challenges->wherePivot('status', request('status'));
        }

        // Ejecuta la query (filtrada o no)
        $challenges = $challenges->get();

        // Badges que tiene el usuario
        $badges = $user->badges;

        // Estados únicos, sentencia SQL pura dentro de una consulta Eloquent de Laravel
        $availableStatuses = $user->challenges()
            ->selectRaw('DISTINCT challenge_user.status')
            ->pluck('status');//solo devuelveme la columna status

        // Pasa todos los datos a la vista
        return view('user.challenges', compact('user', 'challenges', 'badges', 'availableStatuses'));

        // Sin filtro por estado
        //     $challenges = $user->challenges()->withPivot('status', 'completed_at');
        //     $badges = $user->badges;
        //     return view('user.challenges', compact('user', 'challenges', 'badges', 'availableStatuses'));
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


    public function updateChallengeStatus(Request $request, User $user, Challenge $challenge)
    {
        $request->validate([
            'status' => 'required|in:completado,fallido',
        ]);

        if ($request->status === 'completado') {
            $completedAt = now();  // Momentu honetako data eta ordua jarriko dugu
        } else {
            $completedAt = null;
        }

        //actualiza la tabla intermedia n-m
        $user->challenges()->updateExistingPivot($challenge->id, [
            'status' => $request->status,
            'completed_at' => $completedAt
        ]);

        if ($request->status === 'completado') {   // Behin datua aldatuta dagoenean, insignia berriak begiratu
            $this->checkForBadges($user);
        }

        return redirect()->back()->with('success', 'Status-a ondo aldatu da.');
    }

    public function retryChallenge(User $user, Challenge $challenge)
    {
        $user->challenges()->updateExistingPivot($challenge->id, [
            'status' => 'pendiente', //en la vista se controla que pasa al ser status pendiente
            'completed_at' => null
        ]);

        return back()->with('success', 'Te has vuelto a apuntar al reto.');
    }

    public function destroyChallenge(User $user, Challenge $challenge)
    {
        $user->challenges()->detach($challenge->id);//elimina de la tabla intermedia el challenge
        return back()->with('success', 'Has eliminado tu participación en el reto.');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:5',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'points' => 0,
    ]);

    Auth::login($user);

    return redirect()->route('challenges.index');
}

public function edit(User $user)
{
    return view('user.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    // guarda imagen en la path y actualiza el campo en la base
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $user->image = $imageName;
    }   

    $user->update($validated);
    $user->save();


    return redirect()->route('challenges.index')->with('success', 'Perfil actualizado correctamente.');
}

}
