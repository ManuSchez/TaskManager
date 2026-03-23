<x-layouts::app :title="__('Tableros de ') . $workspace->name">
    @include('admin.boards.partials.header', ['workspace' => $workspace])

    <div class="flex gap-6 overflow-x-auto pb-6 items-start select-none" id="boards_draganddrop"
        wire:key="boards-container-{{ count($boards) }}">

        @foreach ($boards as $board)
            <div data-id="{{ $board->id }}" wire:key="board-{{ $board->id }}"
                class="min-w-[340px] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-6 shadow-md shrink-0">

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

    <style>
        .blue-background-class {
            opacity: 0.4 !important;
            background: #ebf4ff !important;
            border: 2px dashed #3b82f6 !important;
        }

        .board-drag-handle {
            cursor: grab !important;
        }

        .board-drag-handle:active {
            cursor: grabbing !important;
        }

        .board-drag-handle * {
            pointer-events: none;
        }

        [data-id] {
            user-select: none;
            -webkit-user-drag: element;
        }
    </style>

    @push('js')
        @include('admin.boards.partials.scripts')
    @endpush
</x-layouts::app>
