<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Column;
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
            'order' => $board->columns()->count() + 1,
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Lista creada!',
            'html' => 'La columna <b>' . e($request->name) . '</b> ha sido añadida a <b>' . e($board->name) . '</b>.',
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
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Column $column)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $column->update([
            'name' => $request->name,
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => '¡Actualizado!',
            'html' => 'La lista ahora se llama <b>' . e($column->name) . '</b>.',
            'timer' => 1500,
            'showConfirmButton' => false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Column $column)
    {
        $nombre = $column->name;
        $column->delete();

        return back()->with('swal', [
            'icon' => 'warning',
            'title' => 'Columna eliminada',
            'text' => "Se ha borrado la lista: $nombre",
            'timer' => 1500
        ]);
    }

    public function toggleFinished(Column $column)
    {
        $column->update(['is_finished' => !$column->is_finished]);

        $mensaje = $column->is_finished ? '¡Columna completada!' : 'Columna reabierta';

        return back()->with('swal', [
            'icon' => 'success',
            'title' => $mensaje,
            'timer' => 1200,
            'showConfirmButton' => false
        ]);
    }
}
