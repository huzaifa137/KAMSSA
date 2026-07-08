<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            font-size:16px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #007bff;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }
        .footer {
            font-size: 0.9em;
            color: #666;
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #eaeaea;
            padding-top: 10px;
        }
        .highlight {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 3px;
            display: block;
            margin: 10px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        p{
            font-size:14px !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to UP</h1>
        </div>
        <h3>Dear {{$name}},</h3>
        <p>These are the provided new user credentials and password which have been created :</p>
        
        <p>Below are your login credentials:</p>
        
        <div class="highlight">
            <strong>Supplier Reference Number:</strong> {{$sup_ref}} <br>
            <strong>Email:</strong> {{$email}} <br>
            <strong>Password:</strong> {{$password}}
        </div>
       
        <p><strong>Login URL:</strong> <a href="{{$url}}">{{$url}}</a></p>
   
        <div class="footer">
            <p><strong>Important:</strong> Please keep this information confidential. If you suspect that your password has been compromised, change it immediately or/and contact us.</p>
        </div>
    </div>
</body>
</html>
