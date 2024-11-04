<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class PokedexController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Página atual (1 por padrão)
        $limit = 20; // Número de pokémons por página
        $offset = ($page - 1) * $limit; // Calcula o offset

        // URL da PokeAPI com parâmetros de paginação
        $apiUrl = "https://pokeapi.co/api/v2/pokemon?limit={$limit}&offset={$offset}";

        // Fazendo a requisição para a API
        $response = Http::get($apiUrl);
        $pokemons = $response->json();

        // Número total de pokémons para calcular o número de páginas
        $totalPokemons = $pokemons['count'];
        $totalPages = ceil($totalPokemons / $limit);

        return view('pokedex.index', compact('pokemons', 'page', 'totalPages'));
    }

    public function search(Request $request)
    {
        // Recebe os parâmetros de busca
        $type = $request->input('type');
        $habitat = $request->input('habitat');
        $name = $request->input('name');

        $results = [];

        // Busca por Tipo
        if ($type) {
            $typeResponse = Http::get("https://pokeapi.co/api/v2/type/" . strtolower($type));
            if ($typeResponse->ok()) {
                $typeData = $typeResponse->json();
                $results['type'] = collect($typeData['pokemon'])->pluck('pokemon');
            }
        }

        // Busca por Habitat
        if ($habitat) {
            $habitatResponse = Http::get("https://pokeapi.co/api/v2/pokemon-habitat/" . strtolower($habitat));
            if ($habitatResponse->ok()) {
                $habitatData = $habitatResponse->json();
                $results['habitat'] = collect($habitatData['pokemon_species'])->pluck('name');
            }
        }

        // Busca por Nome
        if ($name) {
            $nameResponse = Http::get("https://pokeapi.co/api/v2/pokemon?limit=1000");
            if ($nameResponse->ok()) {
                $allPokemon = collect($nameResponse->json()['results']);
                $results['name'] = $allPokemon->filter(function ($pokemon) use ($name) {
                    return str_contains(strtolower($pokemon['name']), strtolower($name));
                })->pluck('name');
            }
        }

        $filteredResults = collect();

        // Verifica quais filtros estão preenchidos e aplica interseção condicionalmente
        if (!empty($results['type']) && !empty($results['habitat']) && !empty($results['name'])) {
            // Interseção entre todos os três arrays (type, habitat e name)
            $filteredResults = collect($results['type'])->pluck('name')
                ->intersect($results['habitat'])
                ->intersect($results['name']);
        } elseif (!empty($results['type']) && !empty($results['habitat'])) {
            // Interseção entre type e habitat
            $filteredResults = collect($results['type'])->pluck('name')
                ->intersect($results['habitat']);
        } elseif (!empty($results['type']) && !empty($results['name'])) {
            // Interseção entre type e name
            $filteredResults = collect($results['type'])->pluck('name')
                ->intersect($results['name']);
        } elseif (!empty($results['habitat']) && !empty($results['name'])) {
            // Interseção entre habitat e name
            $filteredResults = collect($results['habitat'])
                ->intersect($results['name']);
        } else {
            // Se apenas um filtro estiver ativo, use-o como resultado final
            if (!empty($results['type'])) {
                $filteredResults = collect($results['type'])->pluck('name');
            } elseif (!empty($results['habitat'])) {
                $filteredResults = collect($results['habitat']);
            } elseif (!empty($results['name'])) {
                $filteredResults = collect($results['name']);
            }
        }

        // Remove duplicatas, se houver, e converte para coleção final
        $filteredResults = $filteredResults->unique();

        // Definindo itens por página
        $perPage = 10;

        // Paginação manual da coleção
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageResults = $filteredResults->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedResults = new LengthAwarePaginator($currentPageResults, $filteredResults->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        return view('pokedex.results', compact('paginatedResults'));
    }
}
