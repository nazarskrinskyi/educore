<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сертифікат - {{ $course->title }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            background: white;
            width: 297mm;
            height: 210mm;
            position: relative;
        }

        .certificate-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        /* Decorative border */
        .certificate {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 20mm;
            border: 8px solid #2c3e50;
            background: white;
        }

        .certificate::before {
            content: '';
            position: absolute;
            top: 25mm;
            left: 25mm;
            right: 25mm;
            bottom: 25mm;
            border: 3px solid #3498db;
            pointer-events: none;
        }

        /* Corner decorations */
        .corner-decoration {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 3px solid #3498db;
        }

        .corner-decoration.top-left {
            top: 22mm;
            left: 22mm;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: 22mm;
            right: 22mm;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: 22mm;
            left: 22mm;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: 22mm;
            right: 22mm;
            border-left: none;
            border-top: none;
        }

        /* Header section */
        .header {
            text-align: center;
            margin-bottom: 15mm;
            position: relative;
            z-index: 1;
        }

        .logo {
            font-size: 32px;
            color: #2c3e50;
            font-weight: bold;
            letter-spacing: 4px;
            margin-bottom: 5mm;
            text-transform: uppercase;
        }

        .logo-subtitle {
            font-size: 12px;
            color: #7f8c8d;
            letter-spacing: 2px;
            margin-bottom: 8mm;
        }

        /* Certificate title */
        h1 {
            font-size: 64px;
            color: #2c3e50;
            margin-bottom: 3mm;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .subtitle {
            font-size: 20px;
            color: #7f8c8d;
            margin-bottom: 10mm;
            font-style: italic;
            letter-spacing: 1px;
        }

        /* Content section */
        .content {
            text-align: center;
            margin: 0 auto;
            max-width: 220mm;
            position: relative;
            z-index: 1;
        }

        .presented-to {
            font-size: 16px;
            color: #555;
            margin-bottom: 3mm;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .recipient-name {
            font-size: 42px;
            color: #3498db;
            font-weight: bold;
            margin: 5mm 0;
            padding: 3mm 10mm;
            border-bottom: 4px solid #3498db;
            display: inline-block;
            letter-spacing: 2px;
        }

        .achievement-text {
            font-size: 16px;
            color: #555;
            margin: 8mm 0 5mm;
            line-height: 1.6;
            font-weight: 500;
        }

        .course-title {
            font-size: 28px;
            color: #2c3e50;
            font-weight: bold;
            margin: 5mm 0;
            padding: 4mm 8mm;
            background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%);
            border-left: 5px solid #3498db;
            border-right: 5px solid #3498db;
            display: inline-block;
            max-width: 180mm;
            line-height: 1.4;
        }

        /* Course details */
        .course-details {
            margin: 8mm 0;
            font-size: 14px;
            color: #666;
            line-height: 1.8;
        }

        .course-details strong {
            color: #2c3e50;
            font-weight: 600;
        }

        /* Footer section */
        .footer {
            position: absolute;
            bottom: 30mm;
            left: 30mm;
            right: 30mm;
            display: table;
            width: calc(100% - 60mm);
        }

        .signature-section {
            display: table-row;
        }

        .signature-block {
            display: table-cell;
            text-align: center;
            padding: 0 10mm;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 2px solid #2c3e50;
            margin-bottom: 2mm;
            padding-top: 15mm;
        }

        .signature-title {
            font-size: 12px;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1mm;
        }

        .signature-name {
            font-size: 11px;
            color: #7f8c8d;
            font-style: italic;
        }

        /* Certificate info */
        .certificate-info {
            position: absolute;
            bottom: 22mm;
            left: 30mm;
            right: 30mm;
            text-align: center;
            font-size: 11px;
            color: #95a5a6;
            border-top: 1px solid #ecf0f1;
            padding-top: 3mm;
        }

        .certificate-number {
            font-weight: 600;
            color: #7f8c8d;
            letter-spacing: 1px;
        }

        .issue-date {
            margin-top: 1mm;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(52, 152, 219, 0.03);
            font-weight: bold;
            letter-spacing: 10px;
            pointer-events: none;
            z-index: 0;
        }

        /* Seal/Badge */
        .seal {
            position: absolute;
            bottom: 35mm;
            right: 35mm;
            width: 80px;
            height: 80px;
            border: 4px solid #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .seal-content {
            text-align: center;
            font-size: 10px;
            color: #3498db;
            font-weight: bold;
            line-height: 1.3;
        }

        .seal-year {
            font-size: 16px;
            display: block;
            margin-top: 2px;
        }

        /* QR Code placeholder */
        .qr-code {
            position: absolute;
            bottom: 35mm;
            left: 35mm;
            width: 70px;
            height: 70px;
            border: 2px solid #ecf0f1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #bdc3c7;
            text-align: center;
            padding: 5px;
        }

        @media print {
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate">
            <!-- Corner decorations -->
            <div class="corner-decoration top-left"></div>
            <div class="corner-decoration top-right"></div>
            <div class="corner-decoration bottom-left"></div>
            <div class="corner-decoration bottom-right"></div>

            <!-- Watermark -->
            <div class="watermark">EDUCORE</div>

            <!-- Header -->
            <div class="header">
                <div class="logo">EDUCORE</div>
                <div class="logo-subtitle">ONLINE LEARNING PLATFORM</div>
            </div>

            <!-- Main content -->
            <div class="content">
                <h1>СЕРТИФІКАТ</h1>
                <p class="subtitle">Certificate of Completion</p>

                <p class="presented-to">Цей сертифікат видається</p>
                <div class="recipient-name">{{ $user->name }}</div>

                <p class="achievement-text">
                    За успішне завершення онлайн-курсу та демонстрацію<br>
                    високого рівня знань і професійних навичок у напрямку
                </p>

                <div class="course-title">{{ $course->title }}</div>

                <div class="course-details">
                    @if(isset($course->description))
                    <p><strong>Опис курсу:</strong> {{ Str::limit($course->description, 150) }}</p>
                    @endif
                    @if(isset($duration))
                    <p><strong>Тривалість:</strong> {{ $duration }}</p>
                    @endif
                    @if(isset($instructor))
                    <p><strong>Викладач:</strong> {{ $instructor }}</p>
                    @endif
                </div>
            </div>

            <!-- Signatures -->
            <div class="footer">
                <div class="signature-section">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-title">Директор платформи</div>
                        <div class="signature-name">EduCore Administration</div>
                    </div>
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-title">Керівник курсу</div>
                        <div class="signature-name">{{ $instructor ?? 'Course Instructor' }}</div>
                    </div>
                </div>
            </div>

            <!-- Certificate info -->
            <div class="certificate-info">
                <div class="certificate-number">
                    Сертифікат № {{ $certificateNumber ?? 'EC-' . str_pad($user->id, 6, '0', STR_PAD_LEFT) . '-' . str_pad($course->id, 4, '0', STR_PAD_LEFT) }}
                </div>
                <div class="issue-date">
                    Дата видачі: {{ $date }} | Verify at: educore.com/verify/{{ $certificateNumber ?? '' }}
                </div>
            </div>

            <!-- QR Code placeholder -->
            <div class="qr-code">
                <div>
                    QR<br>CODE<br>
                    <small>Verify</small>
                </div>
            </div>

            <!-- Official seal -->
            <div class="seal">
                <div class="seal-content">
                    OFFICIAL<br>CERTIFICATE
                    <span class="seal-year">{{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
