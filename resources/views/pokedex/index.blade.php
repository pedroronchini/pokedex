@extends('layouts.app')

@section('content')
    <form action="{{ route('pokedex.search') }}" method="GET" class="mb-6">
        <div class="flex justify-center my-4">
            <input type="text" name="name" placeholder="Nome" class="border p-2 m-2 rounded text-black" />
            <select name="type" class="border p-2 m-2 rounded text-black">
                <option value="" disabled selected>Selecione</option>
                <option value="normal">Normal</option>
                <option value="fighting">Lutador</option>
                <option value="flying">Voador</option>
                <option value="poison">Venenoso</option>
                <option value="ground">Terrestre</option>
                <option value="rock">Pedra</option>
                <option value="bug">Inseto</option>
                <option value="ghost">Fantasma</option>
                <option value="steel">Metálico/Aço</option>
                <option value="fire">Fogo</option>
                <option value="water">Água</option>
                <option value="grass">Planta</option>
                <option value="electric">Elétrico</option>
                <option value="psychic">Psíquico</option>
                <option value="ice">Gelo</option>
                <option value="dragon">Dragão</option>
                <option value="dark">Sombrio</option>
                <option value="fairy">Fada</option>
                <option value="stellar">Água</option>
                <option value="unknown">Tipo Desconhecido</option>
            </select>
            <select name="habitat" class="border p-2 m-2 rounded text-black">
                <option value="" disabled selected>Selecione</option>
                <option value="cave">Caverna</option>
                <option value="forest">Floresta</option>
                <option value="grassland">Campo</option>
                <option value="mountain">Montanha</option>
                <option value="rare">Raro</option>
                <option value="rough-terrain">Terreno Acidentado</option>
                <option value="sea">Mar</option>
                <option value="urban">Urbano</option>
                <option value="waters-edge">Beira da Água</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Buscar</button>
        </div>
    </form>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($pokemons['results'] as $pokemon)
            <div class="pokemon-card border p-4 rounded text-center bg-white text-black" data-name="{{  $pokemon['name'] }}">
                <h3 class="text-center">{{ ucfirst($pokemon['name']) }}</h3>
                    <img src="https://img.pokemondb.net/artwork/{{ $pokemon['name'] }}.jpg" alt="{{ $pokemon['name'] }}"
                    class="w-20 h-20 mx-auto">
            </div>
        @endforeach
    </div>

    <!-- Links de Paginação -->
    <div class="flex justify-center mt-4">
        @if ($page > 1)
            <a href="{{ url()->current() }}?page={{ $page - 1 }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded mr-2">Anterior</a>
        @endif

        <!-- Mostrar primeira página -->
        <a href="{{ url()->current() }}?page=1" class="px-4 py-2 {{ $page == 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded mr-2">1</a>

        <!-- Mostrar páginas intermediárias com elipses -->
        @if ($page > 4)
            <span class="px-4 py-2">...</span>
        @endif

        @for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++)
            <a href="{{ url()->current() }}?page={{ $i }}" class="px-4 py-2 {{ $page == $i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded mr-2">
                {{ $i }}
            </a>
        @endfor

        @if ($page < $totalPages - 3)
            <span class="px-4 py-2">...</span>
        @endif

        <!-- Mostrar última página -->
        <a href="{{ url()->current() }}?page={{ $totalPages }}" class="px-4 py-2 {{ $page == $totalPages ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded mr-2">
            {{ $totalPages }}
        </a>

        @if ($page < $totalPages)
            <a href="{{ url()->current() }}?page={{ $page + 1 }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Próximo</a>
        @endif
    </div>
@endsection

<!-- Modal para Exibir Informações do Pokémon -->
<div id="pokemonModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 w-96 p-6 rounded-lg shadow-lg relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
            ✖
        </button>

        <!-- Detalhes do Pokémon -->
        <div id="pokemonDetails">
            <img id="pokemonImage" src="" alt="Imagem do Pokémon" class="w-32 h-32 mx-auto">
            <h2 id="pokemonName" class="text-2xl font-bold text-center mt-4"></h2>
            <div id="pokemonTypes" class="flex justify-center space-x-2 mt-2"></div>
            <p id="pokemonDescription" class="text-center mt-4"></p>
            <ul id="pokemonStats" class="mt-4 space-y-2">
                <!-- Estatísticas do Pokémon (preenchidas dinamicamente) -->
            </ul>
        </div>
    </div>
</div>
