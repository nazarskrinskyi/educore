<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сертифікат - {{ $course->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .certificate-wrapper {
            background: white;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }

        .certificate {
            border: 15px solid #4CAF50;
            padding: 60px 40px;
            text-align: center;
            position: relative;
            background: linear-gradient(to bottom, #ffffff 0%, #f9f9f9 100%);
        }

        .certificate::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px dashed #4CAF50;
            pointer-events: none;
        }

        .logo {
            font-size: 24px;
            color: #4CAF50;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        h1 {
            font-size: 56px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            font-style: italic;
        }

        h2 {
            font-size: 28px;
            color: #555;
            margin: 20px 0 10px;
            font-weight: 600;
        }

        .recipient-name {
            font-size: 36px;
            color: #4CAF50;
            font-weight: bold;
            margin: 20px 0;
            padding: 10px 20px;
            border-bottom: 3px solid #4CAF50;
            display: inline-block;
        }

        .course-title {
            font-size: 28px;
            color: #333;
            font-weight: bold;
            margin: 20px 0;
            padding: 15px 30px;
            background: #f0f0f0;
            border-radius: 5px;
            display: inline-block;
        }

        .date {
            font-size: 18px;
            color: #666;
            margin: 30px 0 20px;
        }

        .footer-text {
            font-size: 16px;
            color: #888;
            margin-top: 30px;
            font-style: italic;
        }

        .decorative-line {
            width: 100px;
            height: 3px;
            background: #4CAF50;
            margin: 20px auto;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .certificate-wrapper {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate">
            <div class="logo">EDUCORE</div>
            <div class="decorative-line"></div>

            <h1>Сертифікат</h1>
            <p class="subtitle">Certificate of Completion</p>

            <h2>Видається</h2>
            <div class="recipient-name">{{ $user->name }}</div>

            <h2>За успішне завершення курсу</h2>
            <div class="course-title">{{ $course->title }}</div>

            <p class="date">Дата видачі: <strong>{{ $date }}</strong></p>

            <div class="decorative-line"></div>

            <p class="footer-text">EduCore — ваш освітній шлях починається тут!</p>
        </div>
    </div>
</body>
</html>
