<x-layouts::app :title="__('Tableros de ') . $workspace->name">
    @include('admin.boards.partials.header', ['workspace' => $workspace])

    <div class="flex gap-6 overflow-x-auto pb-6 items-start">
        @foreach ($boards as $board)
            <div class="min-w-[340px] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-6 shadow-md shrink-0 transition">
                @include('admin.boards.partials.board-header', ['board' => $board])
                <div class="flex flex-col gap-4">
                    @foreach ($board->columns as $column)
                        @include('admin.columns.partials.column-item', ['column' => $column])
                    @endforeach
                    @include('admin.columns.partials.form-create-column', ['board' => $board])
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