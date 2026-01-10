<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Course Enrollment</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-body h2 {
            color: #667eea;
            font-size: 20px;
            margin-top: 0;
        }
        .email-body p {
            margin: 15px 0;
            font-size: 16px;
        }
        .course-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .course-info strong {
            color: #667eea;
        }
        .cta-button {
            display: inline-block;
            background: #667eea;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .cta-button:hover {
            background: #5568d3;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">EDUCORE</div>
            <h1>🎉 New Student Enrollment!</h1>
        </div>

        <div class="email-body">
            <h2>Hello {{ $course->instructor->name }},</h2>

            <p>Great news! A new student has just enrolled in your course.</p>

            <div class="course-info">
                <p><strong>Course:</strong> {{ $course->title }}</p>
                <p><strong>Enrollment Date:</strong> {{ now()->format('F j, Y') }}</p>
            </div>

            <p>This is a wonderful opportunity to engage with your growing student community. Make sure to:</p>
            <ul>
                <li>Welcome your new student</li>
                <li>Check if they have any questions</li>
                <li>Review your course materials to ensure they're up to date</li>
            </ul>

            <center>
                <a href="{{ url('/admin') }}" class="cta-button">View Dashboard</a>
            </center>

            <p>Keep up the excellent work in creating valuable learning experiences!</p>

            <p>Best regards,<br><strong>The EduCore Team</strong></p>
        </div>

        <div class="email-footer">
            <p><strong>EduCore</strong> - Your Educational Management System</p>
            <p>Your educational path starts here!</p>
        </div>
    </div>
</body>
</html>
