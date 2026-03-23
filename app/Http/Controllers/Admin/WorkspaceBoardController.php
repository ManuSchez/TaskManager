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
        if ($workspace->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este espacio.');
        }

        $boards = $workspace->boards()
            ->with('columns')
            ->orderBy('position', 'asc')
            ->get();

        return view('admin.workspaces.index', compact('workspace', 'boards'));
    }

    public function store(Request $request, $workspaceSlug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $workspace = $user->workspaces()->where('slug', $workspaceSlug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $lastPosition = $workspace->boards()->max('position') ?? 0;

        $workspace->boards()->create([
            'user_id'      => $user->id,
            'name'         => $request->name,
            'slug'         => Str::slug($request->name) . '-' . Str::lower(Str::random(4)),
            'position'     => $lastPosition + 1,
        ]);

        return redirect()->route('workspaces.boards.index', $workspace->slug)
            ->with('success', '¡Tablero creado con éxito!');
    }

    public function reorder(Request $request)
{
    $ids = $request->input('ids');

    if ($ids && is_array($ids)) {
        foreach ($ids as $index => $id) {
            \App\Models\Board::where('id', $id)->update(['position' => $index + 1]);
        }
    }

    return response()->json(['status' => 'success']);
}
}
