<script>
    document.addEventListener('submit', (e) => {
        if (e.target.classList.contains('delete_form')) {
            e.preventDefault();
            const form = e.target;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });

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
                Livewire.dispatch('execute-delete-workspace', { id: event.detail.id });
            }
        });
    });
</script>
