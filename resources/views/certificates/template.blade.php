<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сертифікат</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; padding: 50px; }
        .certificate { border: 10px solid #4CAF50; padding: 50px; }
        h1 { font-size: 50px; margin-bottom: 0; }
        h2 { font-size: 30px; margin-top: 0; }
        p { font-size: 20px; }
    </style>
</head>
<body>
<div class="certificate">
    <h1>Сертифікат</h1>
    <h2>Видається</h2>
    <p><b>{{ $user->name }}</b></p>
    <h2>За успішне завершення курсу</h2>
    <p><b>{{ $course->title }}</b></p>
    <p>Дата: {{ $date }}</p>
    <p>EduCore — ваш освітній шлях починається тут!</p>
</div>
</body>
</html>
