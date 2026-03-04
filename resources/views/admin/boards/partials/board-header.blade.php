<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <div class="w-2 h-8 bg-blue-500 dark:bg-blue-400 rounded-full"></div>
        <h2 class="text-xl font-bold text-zinc-800 dark:text-white">{{ $board->name }}</h2>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('admin.boards.edit', $board) }}">
            <md-standard-icon-button>
                <span class="material-icons text-zinc-500 dark:text-zinc-400">edit</span>
            </md-standard-icon-button>
        </a>

        <form class="delete_form" action="{{ route('admin.boards.destroy', $board) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="appearance-none bg-transparent border-none p-0">
                <md-standard-icon-button style="--md-icon-button-icon-color: #ef4444;">
                    <span class="material-icons">delete</span>
                </md-standard-icon-button>
            </button>
        </form>
    </div>
</div>