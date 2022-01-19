
@if(isset($prefix) && in_array($prefix,['head','body_top','body_bottom']) && $data = $__embed->prefix($prefix))

@foreach($data as $d)
{!! $d !!}
@endforeach

@endif