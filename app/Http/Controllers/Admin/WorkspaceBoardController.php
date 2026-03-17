<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workspace;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WorkspaceBoardController extends Controller
{
    public function index(Workspace $workspace)
    {
        // SEGURIDAD: Si el espacio no es del usuario logueado, portazo (403)
        if ($workspace->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este espacio.');
        }

        $boards = $workspace->boards()
            ->with('columns')
            ->latest()
            ->paginate(10);

        return view('admin.workspaces.index', compact('workspace', 'boards'));
    }

    public function store(Request $request, $workspaceSlug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Buscamos el espacio, pero nos aseguramos de que sea del usuario
        $workspace = $user->workspaces()->where('slug', $workspaceSlug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Creamos el tablero a través del usuario para asegurar el user_id
        $user->boards()->create([
            'name'         => $request->name,
            'slug'         => Str::slug($request->name) . '-' . rand(1000, 9999),
            'workspace_id' => $workspace->id,
        ]);

        return redirect()->route('workspaces.boards.index', $workspace->slug)
            ->with('success', '¡Tablero creado con éxito!');
    }
}