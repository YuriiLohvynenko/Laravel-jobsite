@if ($paginator->hasPages())
{{--    <div class="pagination-container margin-top-30 margin-bottom-0 osj-pagination">--}}
    <div class="pagination-container margin-top-30 margin-bottom-0">
        <nav class="pagination">
            <ul>
                @if ($paginator->onFirstPage())
                    <li class="pagination-arrow"><a href="javascript:;" class="ripple-effect"><i
                                class="icon-material-outline-keyboard-arrow-left"></i></a></li>
                @else
                    <li class="page-item">
                    <li class="pagination-arrow">
                        <a href="{{ $paginator->previousPageUrl() }}" class="ripple-effect page-no-button" data-page-no="{{ substr($paginator->previousPageUrl(), -1) }}"><i
                                class="icon-material-outline-keyboard-arrow-left"></i></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><a href="javascript:;" class="ripple-effect disabled">{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><a href="javascript:;" class="ripple-effect current-page" data-page-no="{{ $page }}">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}" class="ripple-effect page-no-button" data-page-no="{{ $page }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="pagination-arrow"><a href="{{ $paginator->nextPageUrl() }}" class="ripple-effect page-no-button" data-page-no="{{ substr($paginator->nextPageUrl(), -1) }}"><i
                                class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                @else
                    <li class="pagination-arrow"><a href="javascript:;" class="ripple-effect"><i
                                class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                @endif
            </ul>
        </nav>
    </div>
@endif
