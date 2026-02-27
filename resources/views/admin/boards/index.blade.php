<x-layouts::app :title="__('Boards')">

    {{-- Breadcrumbs y botón Nuevo --}}
    <div class="mb-6 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Boards</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('admin.boards.create') }}" 
           class="btn btn-blue text-xs px-4 py-2 rounded hover:bg-blue-600 transition">
            Nuevo
        </a>
    </div>

    {{-- Tablero tipo Trello --}}
    <div class="flex space-x-6 overflow-x-auto pb-4">
        
        {{-- Columna Boards --}}
        <div class="bg-neutral-secondary-soft dark:bg-zinc-700 rounded-lg p-3 w-80 flex-shrink-0 shadow-md hover:shadow-lg transition">
            <h4 class="font-bold text-lg mb-4 text-center text-gray-800 dark:text-gray-100">Boards</h4>

            @foreach ($boards as $board)
                <div class="bg-white dark:bg-zinc-800 rounded-lg p-4 mb-4 shadow-sm hover:shadow-lg transition transform hover:-translate-y-1">
                    <h5 class="font-semibold mb-2 truncate text-gray-900 dark:text-gray-200">{{ $board->name }}</h5>

                    <div class="flex justify-between items-center mt-2">
                        <a href="{{ route('admin.boards.edit', $board) }}" 
                           class="btn btn-blue text-xs px-2 py-1 rounded hover:bg-blue-600 transition">
                           Editar
                        </a>

                        <form action="{{ route('admin.boards.destroy', $board) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-red text-xs px-2 py-1 rounded hover:bg-red-600 transition">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $boards->links() }}
    </div>

</x-layouts::app>