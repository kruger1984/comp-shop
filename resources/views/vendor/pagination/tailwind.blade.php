@if ($paginator->hasPages())
    <nav>
        <ul class="flex flex-wrap items-center justify-center gap-3">
            @if (!$paginator->onFirstPage())
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="block p-3 text-white hover:text-pink text-sm font-black leading-none">
                        <
                    </a>
                </li>
            @endif

            @foreach($elements as $element)
                @if (is_string($element))
                    <li class="text-body/50 text-sm font-black leading-none" aria-disabled="true">{{ $element }}</li>
                @endif
               @if (is_array($element))
                    @foreach($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <span class="block p-3 pointer-events-none text-pink text-sm font-black leading-none">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{$url}}" class="block p-3 text-white hover:text-pink text-sm font-black leading-none">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
               @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="block p-3 text-white hover:text-pink text-sm font-black leading-none">
                        >
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif


