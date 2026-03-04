<div 
    x-data="{ open: false }" 
    @keydown.escape.window="open = false"
    class="relative"
>

    <!-- Botón -->
    <md-filled-button 
        @click="open = true"
        class="group relative overflow-hidden
               bg-linear-to-r from-blue-600 to-indigo-600
               hover:from-blue-700 hover:to-indigo-700
               active:scale-95
               shadow-md hover:shadow-xl
               transition-all duration-300
               rounded-xl px-5 py-2.5">

        <span class="flex items-center gap-2 font-medium tracking-wide">

            <span class="material-icons text-base
                         transition-all duration-300 ease-out
                         group-hover:rotate-90">
                add
            </span>

            Nuevo Board
        </span>

        <span class="absolute inset-0 rounded-xl
                     bg-white/10 opacity-0
                     group-hover:opacity-100
                     transition duration-300">
        </span>
    </md-filled-button>


    <!-- Modal -->
    <div 
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center"
    >

        <!-- Overlay -->
        <div 
            class="absolute inset-0 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            x-transition.opacity>
        </div>

        <!-- Card -->
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"

            x-init="$watch('open', value => { if (value) $nextTick(() => $refs.nameInput.focus()) })"

            class="relative w-full max-w-md mx-4 p-6
                   bg-white dark:bg-zinc-900
                   border border-zinc-200 dark:border-zinc-700
                   rounded-2xl shadow-2xl"
        >

            <form action="{{ route('admin.boards.store') }}" 
                  method="POST" 
                  class="space-y-5">
                @csrf

                <div class="space-y-1">
                    <h2 class="text-lg font-semibold">
                        Crear nuevo tablero
                    </h2>
                </div>

                <div class="space-y-1">

                    <input type="text"
                           name="name"
                           x-ref="nameInput"
                           placeholder="Nombre del tablero..."
                           required
                           class="w-full rounded-lg px-3 py-2.5 text-sm
                                  border border-zinc-300
                                  dark:border-zinc-700
                                  dark:bg-zinc-800
                                  dark:text-white
                                  focus:ring-2 focus:ring-blue-500
                                  focus:outline-none
                                  transition">
                </div>

                <div class="flex justify-end gap-3 pt-2">

                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 text-sm rounded-lg
                                   border border-zinc-300
                                   dark:border-zinc-700
                                   hover:bg-zinc-100
                                   dark:hover:bg-zinc-800
                                   transition">
                        Cancelar
                    </button>

                    <md-filled-button 
                        type="submit" 
                        class="bg-linear-to-r from-blue-600 to-indigo-600
                               hover:from-blue-700 hover:to-indigo-700
                               active:scale-95
                               transition-all duration-300
                               rounded-lg">
                        Crear tablero
                    </md-filled-button>

                </div>

            </form>
        </div>
    </div>

</div>