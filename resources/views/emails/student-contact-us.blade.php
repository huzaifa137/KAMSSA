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

    <p>A new message has been submitted through the <strong>Contact Us</strong> form by student <strong>{{ $username }}</strong> ({{ $email }}).</p>

    <p><strong>Message:</strong></p>
    <blockquote style="border-left: 4px solid #ccc; margin-left: 20px; padding-left: 10px;">
        {{ $student_message }}
    </blockquote>

    <p style="color: #888;">This is message from the UP system student portal.</p>

</body>
</html>
