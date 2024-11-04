@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-gray-500">❮</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-2">❮</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 bg-blue-500 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-2">❯</a>
        @else
            <span class="px-3 py-2 text-gray-500">❯</span>
        @endif
    </nav>
@endif
