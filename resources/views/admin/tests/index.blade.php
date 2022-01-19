@extends($__layouts.'main')

@section('title', 'Test')

@section('content')


<article class="content items-list-page">
            
    <div class="card">
        <div class="card-block">
            <div class="card-title-block">
                <h3 class="title"> Test </h3>
            </div>
            <section class="card-body">
                "{{$data1}}"
                
            </section>
        </div>
    </div>


</article>

@endsection