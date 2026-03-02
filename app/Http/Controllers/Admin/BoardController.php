<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::with(['columns.tasks'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.boards.index', compact('boards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('admin.boards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:boards,slug',
        ]);

        $board = Board::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'user_id' => Auth::id(), // Asociar al usuario autenticado
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Board creado exitosamente.',
        ]);

        return redirect()->route('admin.boards.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        $board->load('columns.tasks');
        return view('admin.boards.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        return view('admin.boards.edit', compact('board'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $board = Board::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board->update([
            'name' => $request->name,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Board actualizado exitosamente.',
        ]);

        return redirect()->route('admin.boards.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $board->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Tablero eliminada exitosamente.',
        ]);

        return redirect()->route('admin.boards.index');
    }
}
