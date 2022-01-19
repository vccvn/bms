@extends($__layouts.'main')

@section('title', 'Dashboard')

@section('content')

<article class="content dashboard-page">

    @include('admin.dashboard.templates.stats')

    @include('admin.dashboard.templates.posts')
    
    {{-- @include('admin.dashboard.templates.charts') --}}


</article>
@endsection

@section('js')
    @include('admin.dashboard.templates.jsinit')
@endsection