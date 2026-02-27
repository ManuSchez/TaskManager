<x-layouts::app :title="__('Crear Board')">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.boards.index')">Boards</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="card">
        <form action="{{ route('admin.boards.store') }}" method="POST" class="space-y-4">
            @csrf

            <flux:input label="Nombre del Board" name="name" value="{{ old('name') }}" placeholder="Escribe el nombre del board" />

            {{-- Opcional: si quieres mostrar el slug generado --}}
            {{-- <flux:input label="Slug" name="slug" value="{{ old('slug') }}" readonly /> --}}

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    Crear
                </flux:button>
            </div>
        </form>
    </div>

    {{-- SweetAlert --}}
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swalData = @json(session('swal'));
                Swal.fire({
                    icon: swalData.icon || 'info',
                    title: swalData.title || '',
                    text: swalData.text || '',
                    timer: swalData.timer || undefined,
                    showConfirmButton: swalData.showConfirmButton ?? true,
                });
            });
        </script>
    @endif
</x-layouts::app>