<x-layouts::app :title="__('Boards')">

    {{-- Header --}}
    <div class="mb-8 flex justify-between items-end">
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Boards</flux:breadcrumbs.item>
            </flux:breadcrumbs>

            <h1 class="text-3xl font-extrabold text-zinc-800 dark:text-white mt-2">
                Mis Tableros
            </h1>
        </div>

        <a href="{{ route('admin.boards.create') }}" class="no-underline">
            <md-filled-button class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
                <svg slot="icon" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path
                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Nuevo Board
            </md-filled-button>
        </a>
    </div>

    {{-- Contenedor horizontal estilo Trello --}}
    <div class="flex gap-6 overflow-x-auto pb-6">

        @foreach ($boards as $board)
            <div
                class="min-w-85 bg-white dark:bg-zinc-900 
                        border border-zinc-200 dark:border-zinc-700 
                        rounded-lg p-6 shadow-md 
                        shrink-0 transition">

                {{-- Header Board --}}
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-8 bg-blue-500 dark:bg-blue-400 rounded-full"></div>

                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                            {{ $board->name }}
                        </h2>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.boards.edit', $board) }}">
                            <md-standard-icon-button>
                                <span class="material-icons text-zinc-500 dark:text-zinc-400">
                                    edit
                                </span>
                            </md-standard-icon-button>
                        </a>

                        <form class="delete_form" action="{{ route('admin.boards.destroy', $board) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="appearance-none bg-transparent border-none p-0">
                                <md-standard-icon-button style="--md-icon-button-icon-color: #ef4444;">
                                    <span class="material-icons">delete</span>
                                </md-standard-icon-button>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Columnas--}}
                <div class="flex flex-col gap-4 pb-4"> 
                    
                    @foreach ($board->columns as $column)
                        <div
                            class="w-full bg-zinc-100 dark:bg-zinc-800
                    border border-zinc-200 dark:border-zinc-700
                    rounded-xl flex flex-col max-h-130">

                            {{-- Título columna --}}
                            <div class="p-3">
                                <h3
                                    class="text-xs font-bold uppercase tracking-wider 
                           text-zinc-600 dark:text-zinc-400">
                                    {{ $column->name }}
                                </h3>
                            </div>

                            {{-- Tareas --}}
                            <div class="px-2 pb-2 space-y-2 overflow-y-auto">
                                @foreach ($column->tasks as $task)
                                    <div
                                        class="bg-white dark:bg-zinc-700
                                p-3 rounded-lg shadow-sm
                                border border-zinc-200 dark:border-zinc-600
                                hover:border-blue-400 dark:hover:border-blue-500
                                transition cursor-pointer">
                                        <p class="text-sm text-zinc-800 dark:text-zinc-100">
                                            {{ $task->title }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer --}}
                            <div class="p-2 mt-auto">
                                <button class="w-full flex items-center gap-2 p-2 text-sm font-medium ...">
                                    <span class="material-icons text-sm">add</span>
                                    Añadir tarjeta
                                </button>
                            </div>
                        </div>
                    @endforeach

                    {{-- Botón Añadir Columna --}}
                    <div class="w-full"> 
                        <button type="button" ...>
                            <span class="material-icons">add</span>
                            Añadir columna
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
            document.addEventListener('DOMContentLoaded', () => {
                const deleteForms = document.querySelectorAll('.delete_form');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡Esta acción no se puede deshacer!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush

</x-layouts::app>
