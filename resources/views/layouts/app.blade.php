<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <!-- Inclui o Tailwind CSS -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <div class="flex flex-col min-h-screen">
        <header class="bg-blue-500 dark:bg-blue-700 text-white p-4 flex justify-between items-center">
            <div class="container mx-auto flex justify-between items-center">
                <a class="text-2xl font-bold" href="{{ route('pokedex.index') }}">Pokedex</a>
                <!-- Botão de alternância para o modo escuro -->
                <button id="darkModeToggle" class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 p-2 rounded">
                    Alternar Modo
                </button>
            </div>
        </header>

        <main class="container mx-auto py-8 flex justify-center flex-glow">
            <div class="w-full max-w-3xl">
                <!-- Conteúdo principal da página -->
                @yield('content')
            </div>
        </main>

        <footer class="bg-blue-500 dark:bg-blue-700 text-white text-center p-4">
            <p>&copy; {{ date('Y') }} Pokedex. Todos os direitos reservados.</p>
        </footer>
    </div>

    <!-- Inclui o arquivo de JavaScript (opcional, dependendo do projeto) -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @vite('resources/js/app.js')
</body>
</html>
