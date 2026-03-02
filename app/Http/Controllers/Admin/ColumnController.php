<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Board $board)
    {
        $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $board->columns()->create([
        'name' => $request->name,
        'order' => $board->columns()->count() + 1, // Para mantener el orden
    ]);

    return back()->with('swal', [
        'icon' => 'success',
        'title' => '¡Lista creada!',
        'text' => 'La columna se ha añadido correctamente.',
        'timer' => 1500,
        'showConfirmButton' => false
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
