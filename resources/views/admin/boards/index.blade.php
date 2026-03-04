<x-layouts::app :title="__('Boards')">
    {{-- Header de la página --}}
    @include('admin.boards.partials.header')

    {{-- Contenedor horizontal estilo Trello --}}
    <div class="flex gap-6 overflow-x-auto pb-6 items-start">
        @foreach ($boards as $board)
            <div class="min-w-85 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-6 shadow-md shrink-0 transition">
                
                {{-- Header del Board individual --}}
                @include('admin.boards.partials.board-header', ['board' => $board])

                {{-- Listado de Columnas --}}
                <div class="flex flex-col gap-4">
                    @foreach ($board->columns as $column)
                        @include('admin.boards.partials.column-item', ['column' => $column])
                    @endforeach

                    {{-- Formulario para crear columna --}}
                    @include('admin.boards.partials.form-create-column', ['board' => $board])
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $boards->links() }}
    </div>

    @push('js')
        @include('admin.boards.partials.scripts')
    @endpush
</x-layouts::app>