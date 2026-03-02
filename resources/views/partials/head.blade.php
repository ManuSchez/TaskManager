<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Google Material Design Components (MUI Web) --}}
<script type="module" src="https://esm.run/@material/web/all.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

{{-- Estilos de la aplicación --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<style>
    /* Asegura que los componentes de Google usen la fuente de tu proyecto */
    md-filled-button, md-outlined-button, md-elevated-button, md-filled-tonal-button {
        font-family: 'Instrument Sans', sans-serif !important;
        --md-sys-font-label-large: 600 0.875rem 'Instrument Sans';
    }
    /* Aplicar modo oscuro a componentes Material cuando el padre tenga la clase .dark */
    .dark md-filled-button, 
    .dark md-outlined-button, 
    .dark md-standard-icon-button {
        --md-sys-color-on-surface: #e4e4e7;
        --md-sys-color-on-surface-variant: #a1a1aa;
        --md-sys-color-outline: #52525b;
    }
    
    /* Ajuste específico para el icono de editar en dark mode */
    .dark .material-icons {
        color: #a1a1aa !important;
    }
</style>