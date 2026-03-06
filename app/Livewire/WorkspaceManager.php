<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workspace;
use Illuminate\Support\Str;

class WorkspaceManager extends Component
{
    public $name = '';

    public function createWorkspace()
    {
        $this->validate([
            'name' => 'required|min:3|max:20',
        ]);

        auth()->user()->workspaces()->create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'icon' => 'briefcase',
        ]);

        $this->name = '';

        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.workspace-manager');
    }
}