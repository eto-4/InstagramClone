@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1 text-sm">

        {{-- Botó anterior --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 rounded-lg text-gray-300 cursor-not-allowed">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded-lg text-gray-600 hover:bg-gray-100 transition">←</a>
        @endif

        {{-- Pàgines --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 rounded-lg bg-indigo-500 text-white font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 rounded-lg text-gray-600 hover:bg-gray-100 transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botó següent --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded-lg text-gray-600 hover:bg-gray-100 transition">→</a>
        @else
            <span class="px-3 py-1 rounded-lg text-gray-300 cursor-not-allowed">→</span>
        @endif

    </nav>
@endif