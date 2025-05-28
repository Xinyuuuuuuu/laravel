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
        $categories = Category::orderBy('name')->get(); // array de objetos tipo Category, ordenadas por nombre
        $categoryId = $request->category_id;

        if ($categoryId && $categoryId != 0) {
            $selectedCategory = Category::findOrFail($categoryId);//busca la ID de la categoria
            $challenges = $selectedCategory->challenges()->get(); //elementos las challenge de la category seleccionada
            $category = $selectedCategory->name; //guarada el nombre de la categoria
        } else {
            $challenges = Challenge::paginate(6);//pagina solo cuando estamos en la categoria TODOS
            $category = 'Todos';
        }

        return view('challenges.index', compact('challenges', 'categories', 'category'));
    }

    public function show(Challenge $challenge)
    {


        $challenge->load([
            'users' => function ($query) {
                $query->withPivot('status', 'completed_at');
            }
        ]);

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
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('challenges.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'points' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        Challenge::create($validated);

        // return redirect('/');
        return redirect()->route('challenges.index')->with('success', 'Reto creado correctamente.');
    }

}
