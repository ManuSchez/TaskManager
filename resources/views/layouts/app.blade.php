<x-layouts::app.header :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    @stack('js')

    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        (function() {
            function initBoards() {
                const el = document.getElementById('boards_draganddrop');
                if (!el || el.dataset.dragActive === "true") return;

                new Sortable(el, {
                    animation: 150, 
                    ghostClass: 'blue-background-class', 
                    handle: '.board-drag-handle',
                    direction: 'horizontal',

                    onEnd: function() {
                        let ids = Array.from(el.querySelectorAll(':scope > [data-id]'))
                            .map(item => item.getAttribute('data-id'));

                        fetch("{{ route('workspaces.boards.reorder') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    ids: ids
                                })
                            })
                            .then(res => res.json())
                    }
                });

                el.dataset.dragActive = "true";
            }

            initBoards();
            document.addEventListener('livewire:initialized', initBoards);
            document.addEventListener('livewire:navigated', initBoards);
            document.addEventListener('livewire:update', () => {
                const el = document.getElementById('boards_draganddrop');
                if (el) delete el.dataset.dragActive;
                initBoards();
            });
            setInterval(initBoards, 1500);
        })();
    </script>
</x-layouts::app.header>
