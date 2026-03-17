<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workspace;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class WorkspaceManager extends Component
{
    public $name = '';
    public $workspaceId = null;

    public function createWorkspace()
    {
        $this->validate([
            'name' => 'required|min:3|max:20',
        ]);

        if ($this->workspaceId) {
            $workspace = auth()->user()->workspaces()->findOrFail($this->workspaceId);
            $workspace->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);
        } else {
            $workspace = auth()->user()->workspaces()->create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'icon' => 'briefcase',
            ]);
        }

        $this->reset(['name', 'workspaceId']);
        return $this->redirect(route('workspaces.boards.index', $workspace->slug), navigate: true);
    }

    #[On('edit-workspace')]
    public function editWorkspace($id)
    {
        $workspace = auth()->user()->workspaces()->findOrFail($id);
        $this->workspaceId = $id;
        $this->name = $workspace->name;
        $this->js("Flux.modal('create-workspace').show()");
    }

    // Este es el método que ejecutará el borrado real tras el SweetAlert
    #[On('execute-delete-workspace')]
    public function deleteWorkspace($id)
    {
        $workspace = auth()->user()->workspaces()->findOrFail($id);
        $deletedSlug = $workspace->slug;
        $workspace->delete();

        // Evitamos el 404 si el usuario está dentro de la sección borrada
        if (str_contains(request()->header('referer'), $deletedSlug)) {
            return $this->redirect(route('admin.boards.index'), navigate: true);
        }

        return $this->redirect(request()->header('referer'), navigate: true);
    }

    public function render()
    {
        return view('livewire.workspace-manager');
    }
}