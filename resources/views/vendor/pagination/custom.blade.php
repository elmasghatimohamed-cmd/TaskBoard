@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-10">
        <div class="inline-flex items-center bg-slate-800 rounded-xl p-1 shadow-lg border border-slate-700">
            {{-- Bouton Précédent --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-slate-600 cursor-not-allowed">
                    <i class="fas fa-chevron-left text-sm"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
            @endif

            <div class="h-6 w-[1px] bg-slate-700 mx-1"></div>

            {{-- Éléments de pagination --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-4 py-2 text-slate-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg mx-0.5 shadow-md">{{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $url }}" class="px-4 py-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg mx-0.5 transition-all">{{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <div class="h-6 w-[1px] bg-slate-700 mx-1"></div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all">
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            @else
                <span class="px-3 py-2 text-slate-600 cursor-not-allowed">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            @endif
        </div>
    </nav>
@endif

