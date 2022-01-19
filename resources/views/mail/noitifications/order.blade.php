<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    table{
        max-width: 400px;
        width: 100%;
    }
    td{
        padding: 5px;
        border: 1px solid #000;
    }
    td img{
        max-width: 180px;
    }
    .buttons{
        margin: 25px auto;
    }
    a.btn{
        text-decoration: none;
        padding: 10px 20px;
        font-size: 20px;
        color: white;
        background: red;
        border-radius: 5px;
    }
    </style>
</head>
<body>
    

<h4>Xin chào {{$admin}}</h4>
<br>
<br>
{{$order->name}} vừa đặt hàng với những thông tin sau: 
<br>
<br>
@if(count($order->products))
<table>
    <?php $qty = 0; ?>
    @foreach($order->products as $p)
    <?php $prod = $p->detail; ?>
    <tr>
        <td class="image col-md-3 col-4">
            <a href="{{$prod->getViewUrl()}}"><img src="{{$prod->getImage()}}" alt=""></a>
        </td>
        <td class="item col-md-9 col-8">
            <div class="title-sp">
                <h4 class="title">
                    <a href="{{$prod->getViewUrl()}}">
                        {{$prod->name}}
                    </a>
                </h4>
            </div>
            <div class="price">
                <span class="sl-tien">Đơn giá: <strong> {{number_format($p->date_price, 0, ',', '.')}} </strong></span><span class="dv-tien"><strong>VND</strong></span>
            </div>
            <div class="soluong">
                số lượng: {{$p->product_qty}}
                
            </div>
            
        </td>
    </tr>
    <?php $qty+= $p->product_qty; ?>
    @endforeach
    <tr>
        <td>Số sản phẩm</td>
        <td>{{number_format($qty, 0, ',', '.')}}</td>
    </tr>
    <tr>
        <td>Thành tiền</td>
        <td>{{number_format($order->total_money, 0, ',', '.')}} VNĐ</td>
    </tr>
    <tr>
        <td>Tổng tiền sau VAT</td>
        <td>{{number_format($__setting->VAT?($order->total_money*(1+($__setting->VAT/100))):$order->total_money, 0, ',', '.')}} VNĐ</span></td>
    </tr>
</table>

@endif

<br>
<h4>Thông tin đặt hàng</h4>

<table></table>
    <tr>
        <td>Họ tên</td>
        <td>{{$order->name}}</td>
    </tr>
    <tr>
        <td>Số điện thoại</td>
        <td>{{$order->phone_number}}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{$order->email}}</td>
    </tr>
    <tr>
        <td>Địa chỉ giao hàng</td>
        <td>{{$order->address}}</td>
    </tr>
    <tr>
        <td>P.T Thanh toán</td>
        <td>{{$order->getPaymentText()}}</td>
    </tr>
    <tr>
        <td>Thời gian</td>
        <td>{{$order->dateFormat('H:i - d/m/Y')}}</td>
    </tr>
    
</table>

<div class="buttons">
    <a href="{{$order->getDetailUrl()}}" class="btn btn-danger">Xem chi tiết đơn hàng</a>
</div>
    
</body>
</html>
