import './bootstrap';

// Alterna o modo escuro e armazena a preferência no localStorage
document.getElementById('darkModeToggle').addEventListener('click', function () {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
});

// Define o tema inicial com base na preferência do usuário
if (localStorage.getItem('theme') === 'dark' ||
    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
}

// Objeto de mapeamento para tradução dos tipos
const typeTranslations = {
    'normal': 'Normal',
    'fire': 'Fogo',
    'water': 'Água',
    'electric': 'Elétrico',
    'grass': 'Grama',
    'ice': 'Gelo',
    'fighting': 'Lutador',
    'poison': 'Veneno',
    'ground': 'Terra',
    'flying': 'Voador',
    'psychic': 'Psíquico',
    'bug': 'Inseto',
    'rock': 'Pedra',
    'ghost': 'Fantasma',
    'dragon': 'Dragão',
    'dark': 'Noturno',
    'steel': 'Aço',
    'fairy': 'Fada'
};

// Objeto de cores para os tipos
const typeColors = {
    'normal': '#A8A77A',
    'fire': '#EE8130',
    'water': '#6390F0',
    'electric': '#F7D02C',
    'grass': '#7AC74C',
    'ice': '#96D9D6',
    'fighting': '#C22E28',
    'poison': '#A33EA1',
    'ground': '#E2BF65',
    'flying': '#A98FF3',
    'psychic': '#F95587',
    'bug': '#A6B91A',
    'rock': '#B6A136',
    'ghost': '#735797',
    'dragon': '#6F35FC',
    'dark': '#705746',
    'steel': '#B7B7CE',
    'fairy': '#D685AD'
};

// Objeto de mapeamento para a tradução dos Status
const statusTranslations = {
    'hp': 'HP',
    'attack': 'Ataque',
    'defense': 'Defesa',
    'special-attack': 'Ataque Especial',
    'special-defense': 'Defesa Especial',
    'speed': 'Velocidade'
};

document.addEventListener('DOMContentLoaded', function () {
    const pokemonModal = document.getElementById('pokemonModal');
    const closeModal = document.getElementById('closeModal');

    // Função para abrir o modal e buscar dados do Pokémon
    document.querySelectorAll('.pokemon-card').forEach(card => {
        card.addEventListener('click', async function () {
            const pokemonName = this.dataset.name;

            // Faz uma requisição para buscar os detalhes do Pokémon
            const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`);
            const pokemonData = await response.json();

            // Exibe os dados no modal
            document.getElementById('pokemonImage').src = pokemonData.sprites.front_default
                ? pokemonData.sprites.front_default
                : `https://img.pokemondb.net/artwork/${pokemonData.name}.jpg`;

            const pokemonCapitalizeName = pokemonData.name.charAt(0).toUpperCase() + pokemonData.name.slice(1);
            document.getElementById('pokemonName').textContent = pokemonCapitalizeName;

            // Mostra tipos
            const typesContainer = document.getElementById('pokemonTypes');
            typesContainer.innerHTML = ''; // Limpa os tipos anteriores
            pokemonData.types.forEach(typeInfo => {
                const typeName = typeInfo.type.name;
                const translatedType = typeTranslations[typeName] || typeName; // Tradução ou nome original
                const typeColor = typeColors[typeName] || '#A8A8A8'; // Cor do tipo ou cor padrão


                const typeSpan = document.createElement('span');
                typeSpan.textContent = translatedType;
                typeSpan.className = 'px-2 py-1 bg-blue-500 text-white rounded';
                typeSpan.style.backgroundColor = typeColor;
                typesContainer.appendChild(typeSpan);
            });

            // Mostra estatísticas
            const statsContainer = document.getElementById('pokemonStats');
            statsContainer.innerHTML = ''; // Limpa as estatísticas anteriores
            pokemonData.stats.forEach(statInfo => {
                // Obtém o nome traduzido do status ou o original caso não esteja no objeto de tradução
                const translatedStatName = statusTranslations[statInfo.stat.name] || statInfo.stat.name;

                const statItem = document.createElement('li');
                statItem.textContent = `${translatedStatName}: ${statInfo.base_stat}`;
                statsContainer.appendChild(statItem);
            });

            // Exibe o modal
            pokemonModal.classList.remove('hidden');
        });
    });

    // Função para fechar o modal
    closeModal.addEventListener('click', function () {
        pokemonModal.classList.add('hidden');
    });

    // Fecha o modal ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === pokemonModal) {
            pokemonModal.classList.add('hidden');
        }
    });
});
