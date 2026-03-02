<x-layouts::app :title="__('Boards')">

    <div class="mb-6 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Boards</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('admin.boards.create') }}"
            class="btn btn-blue text-xs px-4 py-2 rounded hover:bg-blue-600 transition">
            Nuevo Board
        </a>
    </div>

    @foreach ($boards as $board)
        <div class="mb-8 bg-neutral-secondary-soft dark:bg-zinc-800 rounded-xl p-4 shadow-md">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $board->name }}</h2>
                <div class="flex space-x-2">
                    <form class="edit_form" action="{{route('admin.boards.edit', $board)}}" method="GET">
                        @csrf
                        <button class="btn btn-blue text-xs px-3 py-1 rounded hover:bg-blue-600 transition">
                            Editar
                        </button>
                    </form>
                    <form class="delete_form" action="{{ route('admin.boards.destroy', $board) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red text-xs px-3 py-1 rounded hover:bg-red-600 transition">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Contenedor de columnas tipo Trello --}}
            <div class="flex space-x-6 overflow-x-auto pb-4">

                @foreach ($board->columns as $column)
                    <div class="bg-zinc-200 dark:bg-zinc-700 w-80 rounded-xl p-4 shrink-0 shadow-md">
                        <h3 class="font-bold mb-4 text-lg text-gray-800 dark:text-gray-100">{{ $column->name }}</h3>

                        {{-- Tareas dentro de la columna --}}
                        @foreach ($column->tasks as $task)
                            <div
                                class="bg-white dark:bg-zinc-600 p-3 rounded-lg mb-3 shadow hover:shadow-lg transition">
                                {{ $task->title }}
                            </div>
                        @endforeach

                        {{-- Botón añadir tarea --}}
                        <button class="mt-2 w-full text-sm text-blue-500 hover:underline">
                            + Añadir tarjeta
                        </button>
                    </div>
                @endforeach

                {{-- Botón añadir columna --}}
                <div class="w-80 shrink-0 flex items-center justify-center">
                    <button
                        class="p-4 bg-gray-200 dark:bg-zinc-800 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-300 transition">
                        + Añadir columna
                    </button>
                </div>

            </div>

        </div>
    @endforeach

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $boards->links() }}
    </div>

    @push('js')
        <script>
            forms = document.querySelectorAll('.delete_form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, eliminarlo!",
                        cancelButtonText: "Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush

</x-layouts::app>

@if (session('swal'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const swalData = @json(session('swal'));
            Swal.fire({
                icon: swalData.icon || 'info',
                title: swalData.title || '',
                text: swalData.text || '',
                timer: swalData.timer || undefined,
                showConfirmButton: swalData.showConfirmButton ?? true,
            });
        });
    </script>
@endif
