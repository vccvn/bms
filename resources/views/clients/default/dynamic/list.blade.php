@extends($__layouts.'sidebar')

@include($__utils.'register-meta')

@section('content')
@if(count($list))
                    
                    

                @if($article->slug == 'du-an')
                    @include($__current.'templates.list-style-3')
                @elseif($article->slug == 'dich-vu')
                    @include($__current.'templates.list-style-4')
                @else
                    @include($__current.'templates.list-style-2')
                @endif

            
                {{$list->links('vendor.pagination.corpro')}}

@else

                <div class="alert alert-info">Không có kết quả phù hợp</div>

@endif

@endsection