<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workspace;
use App\Models\Board;
use Illuminate\Http\Request;

class WorkspaceBoardController extends Controller
{
    public function index(Workspace $workspace)
    {
        // Esta línea es la clave:
        // Al usar $workspace->boards(), Laravel aplica automáticamente el 
        // "where('workspace_id', $workspace->id)" por ti.
        $boards = $workspace->boards()
            ->with('columns')
            ->latest() // Opcional: para ver los últimos creados primero
            ->paginate(10);

        return view('admin.workspaces.index', compact('workspace', 'boards'));
    }

    public function store(Request $request, $workspaceSlug)
    {
        // 1. Buscamos el workspace manualmente por el slug
        $workspace = Workspace::where('slug', $workspaceSlug)->firstOrFail();

        // 2. Validamos
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 3. Creamos el tablero
        Board::create([
            'name'         => $request->name,
            'workspace_id' => $workspace->id,
            'user_id'      => auth()->id(),
        ]);

        // 4. Redirigimos usando el slug
        return redirect()->route('workspaces.boards.index', $workspace->slug)
            ->with('success', '¡Tablero creado con éxito!');
    }
}
