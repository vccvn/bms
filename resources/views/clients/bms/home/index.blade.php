@extends($__layouts.'main')


@section('content')

    <div class="home-page">

        @include($__current.'templates.slider')

        @include($__templates.'trip-form')

        <!-- Uư diêm -->

        @include($__current.'templates.featured')

        <!-- block bài viết -->

        @include($__current.'templates.posts')
        
    </div>
@endsection

@section('js')
@include($__utils.'datetime')
@endsection