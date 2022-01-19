@extends($__layouts.'sidebar')


@include($__utils.'register-meta')

@section('content')
@if(count($list))

    @include($__current.'templates.list-style-default')

    {{$list->links('vendor.pagination.corpro')}}

@else

    <div class="alert alert-info">Không có kết quả phù hợp</div>

@endif

@endsection