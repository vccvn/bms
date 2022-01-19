<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>forgot password</title>
	<style>
		*{
			margin: 0;
			padding: 0;
			font-family: sans-serif;
		}
		body{
			background: #fafafafa;
		}
		.container{
			max-width: 520px;
			margin-right: auto;
			margin-left: auto;
			
		}
		header{
			background: #fff;
			box-shadow: 0 0 5px #999;
			padding: 15px 0;
			margin-bottom: 50px;
			border-bottom: 1px solid silver; 
		}
		.card{
			border: 1px silver solid;
			border-radius: 5px;
			margin-bottom: 25px;
			padding: 20px;
			background: #fff;
			max-width: 500px;
			margin-right: auto;
			margin-left: auto;

		}
		p{
			margin: 10px 0;
			font-family: sans-serif;
		}
		p.buttons{
			margin: 30px 0;
			padding: 10px 0;
			text-align: center;
		}
		a{
			text-decoration: none;
			color: #b11316;
		}
		a:hover{
			text-decoration: underline;
		}
		a.btn{
			text-decoration: none;
			color: #fff;
			padding: 8px 10px;
			border-radius: 4px;
			background: #b11316;
		}
		.logo{
			height: 30px;
		}


		footer{
			background: #fff;
			box-shadow: 0 0 5px #999;
			padding: 15px 0; 
			margin-top: 50px;
		}

	</style>
</head>
<body>
	<header>
		<div class="container">
			<img src="{{$setting->logo}}" class="logo" alt="">
		</div>
	</header>
	<div class="container">
		<div class="card">
			<h3>Xin chào, {{$name}}</h3>
			<p>bạn có yêu cầu đặt lại mật khẩu của mình trên {{$setting->company}}</p>
			<p>Hãy nhấp vào "Đặt lại mật khẩu" để tiếp tục</p>
			<p class="buttons">
				<a href="{{$link}}" class="btn btn-primary">Đặt lại mật khẩu</a>
			</p>

			<p class="sub">Nếu bạn có vấn đề gì với nút Khởi tạo lại mật khẩu ở trên, hãy copy đường dẫn dưới đây và truy cập lại bằng trình duyệt.</p>
            <p class="sub">{{$link}}</p>
				
			
		</div>
		
	</div>
	<footer>
		<div class="container">
			<p class="text">
				<a href="{{url('/')}}">{{url('/')}}</a>
			</p>
		</div>
	</footer>
</body>
</html>