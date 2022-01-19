@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @php
        $l = false;
        $r = false;
        $l2 = false;
        $r2 = false;
        $mp = 0;
        @endphp
        @foreach ($elements as $element)
            <?php 
                $cp = $paginator->currentPage();
                $t = $paginator->lastPage();
            ?>
                
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                @if(!$l && !$l2 && $mp < $cp) 
                    @php 
                    $l = true;
                    $l2 = true; 
                    @endphp
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @elseif(!$r && !$r2 && $mp > $cp)
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @php 
                    $r = true; 
                    $r2 = true; 
                    @endphp
                @endif
                
            @endif
            
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @php $mp++; @endphp
                    @if($page == 1 || ($page >= $cp-2 && $page <= $cp+2) || $page == $t)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @elseif($page < $cp-2 && $page > 1 && !$l)
                    @php $l = true; @endphp
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    
                    @elseif($page > $cp+2 && $page < $t && !$r)
                        @php $r = true; @endphp
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
@endif
