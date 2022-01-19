<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>trả lời liên hệ</title>
    <style>
        header{
            box-shadow: 0 0 5px silver;
        }
        header .logo img{
            max-height: 75px;
        }
        .message > div{
            font-size: 15px; 
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="{{route('home')}}">
                <a href="{{route('home')}}"><img src="{{$siteinfo->logo?$siteinfo->logo:asset('themes/clients/corpro/images/logo.png')}}" alt="{{$siteinfo->site_name}}" title="{{$siteinfo->site_name}}"></a>
            </a>
        </div>
    </header>
    <div class="message">
        <div class="message-getting">
            Xin chào {{$contact->name}},
        </div>
        <div class="message-intro">
            Cảm ơn bạn dã gửi liên hệ cho {{$siteinfo->site_name}}. Dưới đây là phản hồi tới bạn.
        </div>
        <div class="message-body">
            {!! nl2br($content) !!}
        </div>

        <div class="message-footer">
            Trân trọng, 
            <br>
            {{$siteinfo->site_name}}
            
            <br><br>

            Để biết thêm thông tin vui lòng truy cập website :  <a href="{{route('home')}}">{{route('home')}}</a>
        </div>

    </div>
</body>
</html>