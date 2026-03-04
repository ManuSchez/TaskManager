<div class="w-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl flex flex-col max-h-130 transition-opacity {{ $column->is_finished ? 'opacity-60' : '' }}"
     x-data="{ isEditing: false, name: '{{ e($column->name) }}', isHovered: false }">
    
    {{-- Header de la Columna --}}
    <div class="p-3" 
         @mouseenter="isHovered = true" 
         @mouseleave="isHovered = false">
         
        {{-- Modo Lectura --}}
        <div x-show="!isEditing" class="flex justify-between items-center min-h-[28px]">
            <div class="flex items-center gap-2 overflow-hidden flex-1">
                @if($column->is_finished)
                    <span class="material-icons text-green-500 text-sm flex-shrink-0">check_circle</span>
                @endif
                <h3 @click="isEditing = true" 
                    class="text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-700 px-1 rounded transition {{ $column->is_finished ? 'line-through' : '' }} truncate">
                    {{ $column->name }}
                </h3>
            </div>

            {{-- Menú de Acciones --}}
            <div class="flex items-center gap-1" 
                 x-show="isHovered" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak>
                
                <form action="{{ route('admin.columns.toggle-finished', $column) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="hover:text-green-600 text-zinc-400 dark:text-zinc-500 transition flex items-center" title="{{ $column->is_finished ? 'Reabrir' : 'Terminar' }}">
                        <span class="material-icons text-lg">{{ $column->is_finished ? 'history' : 'task_alt' }}</span>
                    </button>
                </form>

                <button @click="isEditing = true" class="hover:text-blue-500 text-zinc-400 dark:text-zinc-500 transition flex items-center">
                    <span class="material-icons text-lg">edit</span>
                </button>

                <form action="{{ route('admin.columns.destroy', $column) }}" method="POST" class="delete_form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hover:text-red-500 text-zinc-400 dark:text-zinc-500 transition flex items-center">
                        <span class="material-icons text-lg">delete</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Modo Edición Inline --}}
        <div x-show="isEditing" x-cloak @click.away="isEditing = false">
            <form action="{{ route('admin.columns.update', $column) }}" method="POST" class="flex flex-col gap-2">
                @csrf
                @method('PUT')
                <input 
                    type="text" 
                    name="name" 
                    x-model="name"
                    class="w-full text-xs font-bold uppercase p-1 bg-white dark:bg-zinc-700 border border-blue-500 rounded outline-none text-zinc-800 dark:text-white"
                    @keydown.escape="isEditing = false"
                    x-init="$watch('isEditing', value => value && $nextTick(() => $el.focus()))"
                >
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white text-[10px] px-2 py-1 rounded font-bold hover:bg-blue-700">GUARDAR</button>
                    <button type="button" @click="isEditing = false" class="text-[10px] text-zinc-500 hover:underline">CANCELAR</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de Tareas --}}
    <div class="px-2 pb-2 space-y-2 overflow-y-auto">
        @foreach ($column->tasks as $task)
            <div class="bg-white dark:bg-zinc-700 p-3 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-600 hover:border-blue-400 transition cursor-pointer">
                <p class="text-sm text-zinc-800 dark:text-zinc-100 {{ $column->is_finished ? 'opacity-50' : '' }}">
                    {{ $task->title }}
                </p>
            </div>
        @endforeach
    </div>
</div>