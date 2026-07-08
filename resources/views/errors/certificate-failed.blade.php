<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Not Available</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .error-card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            border-top: 6px solid #dc3545;
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: #fff5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            border: 2px solid #f5c6cb;
        }

        .icon-circle i {
            font-size: 40px;
            color: #dc3545;
        }

        h2 {
            color: #dc3545;
            font-size: 1.6rem;
            margin-bottom: 12px;
        }

        .subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .student-badge {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 30px;
            font-size: 0.95rem;
            color: #495057;
        }

        .student-badge strong {
            color: #263f2e;
            display: block;
            font-size: 1.05rem;
            margin-top: 4px;
        }

        .btn-back {
            background: linear-gradient(135deg, #263f2e 0%, #1a2f20 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(38, 63, 46, 0.4);
            color: white;
        }

        .arabic-note {
            direction: rtl;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #adb5bd;
        }
    </style>
</head>
<body>

    <div class="error-card">

        <div class="icon-circle">
            <i class="fas fa-certificate"></i>
        </div>

        <h2>Certificate Not Available</h2>

        <p class="subtitle">
            This certificate cannot be issued because the student did not pass the examination.
        </p>

        <div class="student-badge">
            Student ID: <strong>{{ $studentId }} &mdash; {{ $studentName }}</strong>
        </div>

        <a href="javascript:window.close()" class="btn-back">
            <i class="fas fa-times me-2"></i> Close Tab
        </a>

        <div class="arabic-note">الشهادة غير متاحة &mdash; لم ينجح الطالب في الامتحان</div>

    </div>

</body>
</html>