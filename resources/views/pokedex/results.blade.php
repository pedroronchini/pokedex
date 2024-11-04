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

    @forelse ($paginatedResults as $pokemon)
        <div class="grid grid-cols-3 gap-4">
            <div class="pokemon-card border p-4 rounded text-center bg-white text-black"
                data-name="{{ is_array($pokemon) ? $pokemon['name'] : $pokemon }}">
                <h3 class="capitalize">{{ is_array($pokemon) ? ucfirst($pokemon['name']) : ucfirst($pokemon) }}</h3>
                @if (is_array($pokemon))
                    <img src="https://img.pokemondb.net/artwork/{{ $pokemon['name'] }}.jpg" alt="{{ $pokemon['name'] }}"
                        class="w-20 h-20 mx-auto">
                @else
                    <img src="https://img.pokemondb.net/artwork/{{ $pokemon }}.jpg" alt="{{ $pokemon }}"
                        class="w-20 h-20 mx-auto">
                @endif
            </div>
        </div>
    @empty
        <div class="text-center">
            <p>Nenhum Pokémon encontrado com os critérios de busca.</p>
        </div>
    @endforelse

    <!-- Exibir Links de Paginação -->
    <div class="mt-4 items-center">
        {{ $paginatedResults->links('vendor.pagination.simple') }}
    </div>
@endsection


<!-- Modal para Exibir Informações do Pokémon -->
<div id="pokemonModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 w-96 p-6 rounded-lg shadow-lg relative">
        <button id="closeModal"
            class="absolute top-2 right-2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
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
