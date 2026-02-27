<x-layouts::app :title="__('Board: ' . $board->name)">

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                {{ $board->name }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="#" class="btn btn-blue text-xs">Nueva columna</a>
    </div>

    <div class="flex space-x-6 overflow-x-auto p-4">
        @foreach ($board->columns as $column)
            <div class="bg-zinc-200 dark:bg-zinc-800 w-80 rounded-xl p-4 shrink-0 shadow-md">
                <h3 class="font-bold mb-4 text-lg">{{ $column->name }}</h3>

                @foreach ($column->tasks as $task)
                    <div class="bg-white dark:bg-zinc-700 p-3 rounded-lg mb-3 shadow hover:shadow-lg transition">
                        {{ $task->title }}
                    </div>
                @endforeach

                <button class="mt-2 text-sm text-blue-500 hover:underline">+ Añadir tarjeta</button>
            </div>
        @endforeach
    </div>

</x-layouts::app>