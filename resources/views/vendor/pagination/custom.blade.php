@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: space-between; align-items: center;">
        <div style="flex: 1;">
            @if ($paginator->onFirstPage())
                <span style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: #f1f5f9; color: #94a3b8; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: not-allowed;">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Précédent
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: white; color: #3b82f6; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Précédent
                </a>
            @endif
        </div>

        <div style="flex: 2; display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="padding: 0.5rem 0.75rem; color: #94a3b8;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; background: #3b82f6; color: white; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#f8fafc'; this.style.color='#3b82f6';" onmouseout="this.style.background='white'; this.style.color='#64748b';">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <div style="flex: 1; display: flex; justify-content: flex-end;">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: white; color: #3b82f6; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    Suivant
                    <svg style="width: 1.25rem; height: 1.25rem; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <span style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: #f1f5f9; color: #94a3b8; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: not-allowed;">
                    Suivant
                    <svg style="width: 1.25rem; height: 1.25rem; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            @endif
        </div>
    </nav>

    <div style="text-align: center; margin-top: 1rem; font-size: 0.875rem; color: #64748b;">
        Affichage de <strong>{{ $paginator->firstItem() }}</strong> à <strong>{{ $paginator->lastItem() }}</strong> sur <strong>{{ $paginator->total() }}</strong> résultats
    </div>
@endif