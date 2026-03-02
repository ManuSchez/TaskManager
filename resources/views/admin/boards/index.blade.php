<x-layouts::app :title="__('Boards')">

    {{-- Header del Dashboard --}}
    <div class="mb-8 flex justify-between items-end">
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Boards</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="text-3xl font-extrabold text-zinc-800 dark:text-white mt-2">Mis Tableros</h1>
        </div>

        {{-- Botón Nuevo Board con color dinámico --}}
        <a href="{{ route('admin.boards.create') }}" class="no-underline">
            <md-filled-button class="bg-blue-600 dark:bg-blue-500">
                <svg slot="icon" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path
                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Nuevo Board
            </md-filled-button>
        </a>
    </div>

    {{-- Contenedor horizontal de boards tipo Trello --}}
    <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-thin scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700">

        @foreach ($boards as $board)
            <div
                class="min-w-[320px] bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-6 shadow-sm transition-colors flex-shrink-0">

                {{-- Board Header --}}
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-8 bg-blue-500 dark:bg-blue-400 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white tracking-tight">{{ $board->name }}</h2>
                    </div>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.boards.edit', $board) }}" class="no-underline">
                            <md-standard-icon-button>
                                <span class="material-icons text-zinc-500 dark:text-zinc-400">edit</span>
                            </md-standard-icon-button>
                        </a>

                        <form class="delete_form" action="{{ route('admin.boards.destroy', $board) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="appearance-none bg-transparent border-none p-0 cursor-pointer">
                                <md-standard-icon-button style="--md-icon-button-icon-color: #ef4444;">
                                    <span class="material-icons">delete</span>
                                </md-standard-icon-button>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Columnas dentro del board --}}
                <div class="flex space-x-4 overflow-x-auto pb-4">

                    @foreach ($board->columns as $column)
                        <div class="bg-zinc-200/70 dark:bg-zinc-800/80 w-72 rounded-xl flex flex-col max-h-[550px] shrink-0 border border-zinc-300 dark:border-zinc-700 transition-colors">

                            {{-- Título Columna --}}
                            <div class="p-3 pb-0">
                                <h3 class="font-bold text-xs text-zinc-600 dark:text-zinc-400 px-2 py-1 uppercase tracking-widest">
                                    {{ $column->name }}
                                </h3>
                            </div>

                            {{-- Lista de Tareas --}}
                            <div class="p-2 overflow-y-auto space-y-2">
                                @foreach ($column->tasks as $task)
                                    <div
                                        class="bg-white dark:bg-zinc-700 p-3 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-600 hover:border-blue-400 dark:hover:border-blue-500 transition-all cursor-pointer group">
                                        <p class="text-sm text-zinc-800 dark:text-zinc-100 leading-snug">{{ $task->title }}</p>
                                        <div class="mt-2 flex opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="text-[10px] text-zinc-400 dark:text-zinc-500 font-mono">#{{ $task->id }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer Columna --}}
                            <div class="p-2 mt-auto">
                                <button class="flex items-center gap-2 w-full p-2 text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-300/50 dark:hover:bg-zinc-700/50 rounded-lg transition text-left font-medium">
                                    <span class="material-icons text-sm">add</span>
                                    Añadir una tarjeta
                                </button>
                            </div>
                        </div>
                    @endforeach

                    {{-- Botón Añadir Columna --}}
                    <div class="w-72 shrink-0">
                        <button class="w-full flex items-center gap-2 p-3 bg-zinc-200/40 dark:bg-zinc-800/40 hover:bg-zinc-200/70 dark:hover:bg-zinc-800/70 border border-dashed border-zinc-400 dark:border-zinc-600 rounded-xl text-zinc-700 dark:text-zinc-300 transition-all font-medium text-sm">
                            <span class="material-icons">add</span>
                            Añadir otra lista
                        </button>
                    </div>

                </div>

            </div>
        @endforeach

    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $boards->links() }}
    </div>

    @push('js')
        <script>
            document.querySelectorAll('.delete_form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const isDark = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        title: "¿Eliminar tablero?",
                        text: "Esta acción es permanente",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ef4444",
                        cancelButtonColor: "#71717a",
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "Cancelar",
                        background: isDark ? '#18181b' : '#fff',
                        color: isDark ? '#fff' : '#000',
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        </script>
    @endpush
</x-layouts::app>