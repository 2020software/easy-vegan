<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>請求 No : {{ $order['invoice_no'] }}</h3>
    <h3>名前 : {{ $order['name'] }}</h3>
    <h3>Email : {{ $order['email'] }}</h3>
</body>
</html>