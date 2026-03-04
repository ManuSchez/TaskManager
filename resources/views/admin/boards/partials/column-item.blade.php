<div class="w-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl flex flex-col max-h-130">
    <div class="p-3">
        <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400">
            {{ $column->name }}
        </h3>
    </div>

    <div class="px-2 pb-2 space-y-2 overflow-y-auto">
        @foreach ($column->tasks as $task)
            <div class="bg-white dark:bg-zinc-700 p-3 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-600 hover:border-blue-400 transition cursor-pointer">
                <p class="text-sm text-zinc-800 dark:text-zinc-100">{{ $task->title }}</p>
            </div>
        @endforeach
    </div>

    <div class="p-2 mt-auto">
        <button class="w-full flex items-center gap-2 p-2 text-sm font-medium hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
            <span class="material-icons text-sm">add</span>
            Añadir tarjeta
        </button>
    </div>
</div>