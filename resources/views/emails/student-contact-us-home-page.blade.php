<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
    </style>
</head>

<body>

    <p>Dear <span style="color:green;">Admin (UgandanProgrammer),</span></p>

    <p>A new message has been submitted through the <strong>Home page Contact Us</strong> form by user
        <strong>{{ $username }}</strong> and phone number <strong>({{ $phonenumber }})</strong>.
    </p>

    <p><strong>Subject:</strong>{{ $student_message }}</p>
    <p><strong>Message:</strong></p>
    <blockquote style="border-left: 4px solid #ccc; margin-left: 20px; padding-left: 10px;">
        {{ $student_message }}
    </blockquote>

</body>

</html>
