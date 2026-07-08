<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP</title>
</head>
<body>
    <h1 style="color:green;">OTP - One Time Password</h1>
    <p>Dear {{$username}}, </p>
    <p>Please use the OTP below to continue</p>
    <h2 style=="font-weight:bold;">OTP: <span style="color: red;font-weight:bold">{{$generatedOTP}}</span> </h2>
    <p>Please note that this password will expire after 15 minutes</p>

    
</body>
</html>