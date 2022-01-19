@extends($__layouts.'sidebar')
@if(isset($category))
    @section('title', $category->name)
    @if($category->feature_image)
        @section('image', $category->getFeatureImage())
    @endif
    @if($category->description)
        @section('description', $category->getShortDesc(500))
    @endif
@elseif(isset($page_title))
    @section('title', $page_title)
@endif
@section('sidebar','shop')

@section('content')
@if(count($list))

    @include($__current.'templates.list-style-1')

    {{$list->links('vendor.pagination.lightsolution')}}

@else

    <div class="alert alert-info text-center">Không có kết quả phù hợp</div>

@endif

@endsection

