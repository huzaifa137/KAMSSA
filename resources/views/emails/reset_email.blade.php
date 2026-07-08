<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart-Schools Password Reset</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            line-height: 1.6;
            color: #333333;
            background-color: #2d9eef; /* Overall blue background */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff; /* White background for content */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px; /* Padding for the header area */
            background-color: #2d9eef; /* Blue background for header */
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            margin: -40px -40px 30px -40px; /* Adjust margin to extend to container edges */
            color: #ffffff; /* White text for header */
        }
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            margin: 0;
            padding-bottom: 10px;
        }
        .content {
            padding: 20px 0;
            text-align: center;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background-color: #2d9eef; /* Blue button */
            color: #ffffff;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #248ad6; /* A slightly darker shade for hover effect */
        }
        .link-text {
            word-break: break-all;
            color: #007bff; /* A standard blue for links, or adjust to complement brand */
            font-size: 14px;
            margin-top: 15px;
            display: block;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: #888888;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div style="background-color:#2d9eef; padding: 30px 0;"> <div class="container">
            <div class="header">
                <h1>Smart-Schools (Reset Password )</h1>
            </div>
            <div class="content">
                <p>Dear <span style="font-weight:bold; color: #333333;">{{ $username }}</span>,</p>
                <p>You've requested to reset your password. Use the link below to set a new one:</p>
                <div class="button-container">
                    <a href="{{ $resetUrl }}" class="button">Reset My Password</a>
                </div>
                <p style="margin-top: 30px;">If the button above doesn't work, you can also copy and paste the following link into your web browser:</p>
                <span class="link-text">{{ $resetUrl }}</span>
            </div>
            <div class="footer">
                <p>&copy; 2025 Smart-Schools. All rights reserved.</p>
                <p>If you did not request a password reset, please ignore this email.</p>
            </div>
        </div>
    </div>
</body>
</html>