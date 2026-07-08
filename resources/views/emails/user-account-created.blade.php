<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Acoount has been created</title>
</head>

<body>

    <p><strong>Dear {{ $username }},</strong></p>

    <p>We are thrilled to inform you that your account has been successfully created on our {{ $systemSettings->system_name ?? 'Iteb Academics' }}! Welcome
        aboard!</p>
    <p><strong>Account Details</strong></p>
    <ol>
        <li>username : {{ $username }}</li>
        <li>Email : {{ $email }}</li>
        <li>passsword : {{ $password }}</li>
    </ol>

    <p>With your new account, you now have access to our exciting,educative and easy to learn videos and resources
        designed to enhance your knowldge and understanding of several topics.
        we're confident you'll find everything you need to make the most out of your time here.</p>

    <p>Here are a few key points to get you started:</p>
</body>

</html>
