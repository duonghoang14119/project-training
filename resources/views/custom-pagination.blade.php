<head>
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
</head>
@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($pagination->onFirstPage())
                <li class="page-item disabled"><span class="page-link pagination-prev">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link pagination-prev" href="{{ $pagination->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($pagination->hasMorePages())
                <li class="page-item"><a class="page-link pagination-next" href="{{ $pagination->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link pagination-next">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
