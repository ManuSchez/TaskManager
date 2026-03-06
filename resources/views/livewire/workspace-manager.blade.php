<div>
    <flux:modal name="create-workspace" class="md:w-[400px]">
        <form wire:submit="createWorkspace" class="space-y-6">
            <div>
                <flux:heading size="lg">Nueva Sección</flux:heading>
                <flux:subheading>Crea un espacio (ej: Trabajo, Personal...)</flux:subheading>
            </div>

            <flux:input 
                wire:model="name" 
                label="Nombre de la sección" 
                placeholder="Ej: Proyectos 2026" 
            />

            <div class="flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Crear Espacio</flux:button>
            </div>
        </form>
    </flux:modal>
</div>