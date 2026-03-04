<div class="mb-8 flex justify-between items-end">
    <div>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Boards</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <h1 class="text-3xl font-extrabold text-zinc-800 dark:text-white mt-2">
            Mis Tableros
        </h1>
    </div>

    <a href="{{ route('admin.boards.create') }}" class="no-underline">
        <md-filled-button class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
            <svg slot="icon" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Nuevo Board
        </md-filled-button>
    </a>
</div>