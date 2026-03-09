<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Task Manager</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="h-full flex flex-col
bg-gradient-to-b from-gray-100 to-gray-200
dark:from-zinc-900 dark:to-black
text-gray-800 dark:text-zinc-100
font-sans">

<!-- HEADER -->
<header class="w-full max-w-6xl mx-auto flex justify-between items-center px-6 py-6">

<div class="flex items-center gap-3">
<img src="/images/Logo.png" alt="Task Manager Logo" class="h-10 w-auto">
<span class="text-lg font-semibold">Task Manager</span>
</div>

<div class="flex gap-3">

<a href="/login"
class="px-4 py-2 rounded-lg
text-sm font-medium
hover:bg-gray-200
dark:hover:bg-zinc-800
transition">
Iniciar sesión
</a>

<a href="/register"
class="px-4 py-2 rounded-lg
bg-black text-white
hover:bg-zinc-800
dark:bg-white dark:text-black
dark:hover:bg-zinc-200
text-sm font-medium
transition">
Registrarse
</a>

</div>

</header>


<!-- HERO -->
<main class="flex-1 flex items-center justify-center px-6">

<div class="text-center max-w-3xl">

<img src="/images/Logo.png"
class="mx-auto h-20 mb-6"
alt="Logo">

<h1 class="text-4xl md:text-5xl font-semibold mb-6 leading-tight">
Organiza tus tareas <br>
<span class="text-gray-500 dark:text-zinc-400">
de forma simple
</span>
</h1>

<p class="text-lg text-gray-600 dark:text-zinc-400 mb-12">
Crea boards, organiza columnas y gestiona tus tareas
con un sistema visual estilo Kanban.
</p>


<!-- FEATURES -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">

<!-- BOARD -->
<div class="p-6 rounded-xl
bg-white dark:bg-zinc-800
shadow-sm hover:shadow-md
transition">

<div class="mb-3 text-black dark:text-white">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-6 h-6"
fill="none"
viewBox="0 0 24 24"
stroke="currentColor">

<rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/>
<line x1="9" y1="4" x2="9" y2="20" stroke-width="2"/>
<line x1="15" y1="4" x2="15" y2="20" stroke-width="2"/>

</svg>

</div>

<h3 class="font-semibold mb-2">Boards</h3>

<p class="text-sm text-gray-500 dark:text-zinc-400">
Organiza proyectos con tableros independientes.
</p>

</div>


<!-- COLUMNAS -->
<div class="p-6 rounded-xl
bg-white dark:bg-zinc-800
shadow-sm hover:shadow-md
transition">

<div class="mb-3 text-black dark:text-white">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-6 h-6"
fill="none"
viewBox="0 0 24 24"
stroke="currentColor">

<rect x="4" y="4" width="4" height="16" stroke-width="2"/>
<rect x="10" y="4" width="4" height="16" stroke-width="2"/>
<rect x="16" y="4" width="4" height="16" stroke-width="2"/>

</svg>

</div>

<h3 class="font-semibold mb-2">Columnas</h3>

<p class="text-sm text-gray-500 dark:text-zinc-400">
Divide tu flujo de trabajo en estados como
pendiente, en progreso y completado.
</p>

</div>


<!-- TAREAS -->
<div class="p-6 rounded-xl
bg-white dark:bg-zinc-800
shadow-sm hover:shadow-md
transition">

<div class="mb-3 text-black dark:text-white">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-6 h-6"
fill="none"
viewBox="0 0 24 24"
stroke="currentColor">

<path stroke-width="2"
d="M9 12l2 2 4-4"/>

<rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/>

</svg>

</div>

<h3 class="font-semibold mb-2">Tareas</h3>

<p class="text-sm text-gray-500 dark:text-zinc-400">
Crea y gestiona tareas fácilmente dentro de cada columna.
</p>

</div>

</div>

</div>

</main>

</body>
</html>