Xin chào {{$data['admin']}},
<br>
<br>
{{$data['name']}} vừa gửi liên hệ với những thông tin sau: 
<br>
<br>
@if($data)

    @foreach($data as $k => $v)

        {{$k}}: {{$v}} <br>
    
    @endforeach
@endif