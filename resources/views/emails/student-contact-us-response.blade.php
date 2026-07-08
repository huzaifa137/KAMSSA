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

        .status {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <p>Dear <span style="color:green;">{{ $username }}</span>,</p>

    <p>A new message has been submitted from Idaad & Thanawi Exam System to you.</p>

    <p><strong>Message:</strong></p>
    <blockquote style="border-left: 4px solid #ccc; margin-left: 20px; padding-left: 10px;">
        {{ $student_message }}
    </blockquote>

    <p><strong>Response Status:</strong>
        <span class="status" style="color: {{ $response_status == 'Responded' ? 'green' : 'red' }};">
            {{ $response_status }}
        </span>
    </p>

    <p>Please log in to the admin panel to respond accordingly if necessary.</p>

    <p style="color: #888;">This is an automated message from the UP system.</p>

</body>

</html>
