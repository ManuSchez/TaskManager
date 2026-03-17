<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    public function index(?Workspace $workspace = null)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $boards = $user->boards()
            ->with(['columns.tasks'])
            ->when($workspace, function ($query) use ($workspace) {
                return $query->where('workspace_id', $workspace->id);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.boards.index', compact('boards', 'workspace'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'workspace_id' => 'required|exists:workspaces,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->boards()->create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . rand(1000, 9999),
            'workspace_id' => $request->workspace_id,
        ]);

        return redirect()->route('admin.boards.index')->with('success', 'Board creado con éxito');
    }

    public function show(Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        $board->load('columns.tasks');
        return view('admin.boards.show', compact('board'));
    }

    public function update(Request $request, Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['name' => 'required|string|max:255']);

        $board->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.boards.index');
    }

    public function destroy(Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        $board->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Tablero eliminado exitosamente.',
        ]);

        return redirect()->route('admin.boards.index');
    }
}
