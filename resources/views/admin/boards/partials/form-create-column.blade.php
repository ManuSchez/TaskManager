<div class="w-full" x-data="{ open: false }"> 
    <button x-show="!open" @click="open = true" type="button" 
        class="w-full p-3 rounded-xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 text-zinc-500 flex items-center justify-center gap-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
        <span class="material-icons">add</span>
        Añadir columna
    </button>

    <form x-show="open" @click.away="open = false" action="{{ route('admin.columns.store', $board->id) }}" method="POST"
        class="bg-zinc-100 dark:bg-zinc-800 p-3 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-inner">
        @csrf
        <input type="text" name="name" placeholder="Nombre de la columna..." 
            class="w-full bg-white dark:bg-zinc-700 border-none rounded-lg p-2 text-sm outline-none mb-2 text-zinc-800 dark:text-white"
            required x-init="$nextTick(() => $el.focus())">
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm font-bold hover:bg-blue-700">Añadir</button>
            <button @click="open = false" type="button" class="text-zinc-500 text-sm hover:underline">Cancelar</button>
        </div>
    </form>
</div>