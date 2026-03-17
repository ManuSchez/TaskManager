@php
    $groups = [
        'Management' => [
            [
                'name' => 'Tableros',
                'icon' => 'rectangle-stack',
                'url' => route('admin.boards.index'),
                'current' => request()->routeIs('admin.boards.*'),
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:header class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 h-16">

        <div class="flex items-center gap-2">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <a href="{{ route('admin.boards.index') }}" wire:navigate class="flex items-center gap-2 px-2">
                <x-app-logo />
            </a>
        </div>

        {{-- NAVBAR PRINCIPAL --}}
        <flux:navbar class="max-lg:hidden gap-6 ml-6">
            <flux:dropdown position="bottom" align="start">
                <flux:button variant="ghost" icon-trailing="chevron-down">
                    <span class="font-semibold">Mis Espacios</span>
                </flux:button>

                <flux:menu class="w-64">
                    <flux:menu.group heading="Secciones">
                        @forelse (auth()->user()->workspaces as $ws)
                            <div class="flex items-center justify-between w-full px-2 py-1.5 rounded-md hover:bg-zinc-200/50 dark:hover:bg-zinc-700/50 transition-colors">
                                {{-- Enlace --}}
                                <a href="{{ route('workspaces.boards.index', $ws->slug) }}" 
                                   wire:navigate
                                   class="text-sm font-medium text-zinc-800 dark:text-zinc-200 no-underline flex-1 truncate mr-2">
                                    {{ $ws->name }}
                                </a>

                                <div class="flex items-center gap-2 shrink-0">
                                    {{-- Botón Editar --}}
                                    <button type="button"
                                        onclick="Livewire.dispatch('edit-workspace', { id: {{ $ws->id }} })"
                                        class="text-zinc-500 hover:text-blue-500 transition-colors p-1 cursor-pointer">
                                        <flux:icon name="pencil-square" variant="micro" />
                                    </button>

                                    {{-- Botón Borrar (Ahora dispara SweetAlert) --}}
                                    <button type="button"
                                        onclick="window.dispatchEvent(new CustomEvent('trigger-delete-workspace', { detail: { id: {{ $ws->id }} } }))"
                                        class="text-zinc-500 hover:text-red-500 transition-colors p-1 cursor-pointer">
                                        <flux:icon name="trash" variant="micro" />
                                    </button>
                                </div>
                            </div>
                        @empty
                            <flux:menu.item disabled>No hay espacios</flux:menu.item>
                        @endforelse
                    </flux:menu.group>

                    <flux:menu.separator />

                    <flux:modal.trigger name="create-workspace">
                        <flux:menu.item icon="plus">Nueva Sección</flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu>
            </flux:dropdown>

            <flux:separator vertical class="my-2" />

            @foreach ($groups as $group => $links)
                @foreach ($links as $link)
                    <flux:navbar.item icon="{{ $link['icon'] }}" :href="$link['url']" :current="$link['current']"
                        wire:navigate>
                        {{ __($link['name']) }}
                    </flux:navbar.item>
                @endforeach
            @endforeach
        </flux:navbar>

        <flux:spacer />

        {{-- NAVBAR DERECHA --}}
        <flux:navbar class="me-1.5">
            <flux:dropdown position="bottom" align="end">
                <flux:button variant="ghost" class="flex items-center gap-2 !rounded-lg px-2">
                    <div class="size-8 overflow-hidden rounded-full border border-zinc-200 dark:border-zinc-700">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="h-full w-full object-cover">
                    </div>
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200 max-sm:hidden">
                        {{ auth()->user()->name }}
                    </span>
                    <flux:icon name="chevron-down" variant="micro" class="text-zinc-400" />
                </flux:button>

                <flux:menu class="w-64">
                    <div class="flex items-center gap-3 px-2 py-2">
                        <img src="{{ auth()->user()->avatar_url }}"
                            class="size-10 rounded-full border border-zinc-200 dark:border-zinc-700">
                        <div class="grid flex-1 text-sm leading-tight">
                            <flux:heading class="font-semibold">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="text-xs text-zinc-500">{{ auth()->user()->email }}</flux:text>
                        </div>
                    </div>
                    <flux:menu.separator />
                    <flux:menu.item :href="route('profile.edit')" icon="user" wire:navigate>Mi Perfil
                    </flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            variant="danger">
                            Cerrar Sesión
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:navbar>
    </flux:header>

    {{-- SIDEBAR MÓVIL --}}
    <flux:sidebar collapsible="mobile" sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo />
            <flux:sidebar.collapse />
        </flux:sidebar.header>
        <flux:sidebar.nav>
            @foreach ($groups as $group => $links)
                <flux:sidebar.group :heading="$group">
                    @foreach ($links as $link)
                        <flux:sidebar.item icon="{{ $link['icon'] }}" :href="$link['url']"
                            :current="$link['current']" wire:navigate>
                            {{ __($link['name']) }}
                        </flux:sidebar.item>
                    @endforeach
                </flux:sidebar.group>
            @endforeach
        </flux:sidebar.nav>
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
    <livewire:workspace-manager />

    {{-- SCRIPTS DE SWEETALERT --}}
    <script>
        window.addEventListener('trigger-delete-workspace', event => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Se eliminarán todos los tableros de esta sección!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llama al método 'execute-delete-workspace' en WorkspaceManager.php
                    Livewire.dispatch('execute-delete-workspace', { id: event.detail.id });
                }
            });
        });
    </script>
</body>

</html>