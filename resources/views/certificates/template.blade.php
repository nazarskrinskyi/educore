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
            background: linear-gradient(135deg, #f0f4f8 0%, #ffffff 50%, #f0f4f8 100%);
        }

        /* Decorative border */
        .certificate {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 12mm;
            background: white;
        }

        /* Outer border frame */
        .border-frame {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 2px solid #1e3a5f;
            pointer-events: none;
        }

        .border-frame::before {
            content: '';
            position: absolute;
            top: 3mm;
            left: 3mm;
            right: 3mm;
            bottom: 3mm;
            border: 1px solid #3498db;
        }

        /* Corner decorations */
        .corner-decoration {
            position: absolute;
            width: 40px;
            height: 40px;
        }

        .corner-decoration.top-left {
            top: 10mm;
            left: 10mm;
            border-top: 3px solid #3498db;
            border-left: 3px solid #3498db;
        }

        .corner-decoration.top-right {
            top: 10mm;
            right: 10mm;
            border-top: 3px solid #3498db;
            border-right: 3px solid #3498db;
        }

        .corner-decoration.bottom-left {
            bottom: 10mm;
            left: 10mm;
            border-bottom: 3px solid #3498db;
            border-left: 3px solid #3498db;
        }

        .corner-decoration.bottom-right {
            bottom: 10mm;
            right: 10mm;
            border-bottom: 3px solid #3498db;
            border-right: 3px solid #3498db;
        }

        /* Header section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 15mm 20mm 8mm;
            position: relative;
            z-index: 1;
            border-bottom: 2px solid #e8f0f8;
        }

        .header-left {
            text-align: left;
        }

        .logo {
            font-size: 28px;
            color: #1e3a5f;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 2mm;
            text-transform: uppercase;
        }

        .logo-subtitle {
            font-size: 10px;
            color: #7f8c8d;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .header-right {
            text-align: right;
            font-size: 9px;
            color: #666;
            line-height: 1.6;
        }

        .header-right strong {
            color: #1e3a5f;
            display: block;
            font-size: 10px;
            margin-bottom: 1mm;
        }

        /* Certificate title */
        .title-section {
            text-align: center;
            margin: 6mm 0 5mm;
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 48px;
            color: #1e3a5f;
            margin-bottom: 2mm;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 6px;
        }

        .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            font-style: italic;
            letter-spacing: 1px;
        }

        /* Content section */
        .content {
            padding: 0 20mm;
            position: relative;
            z-index: 1;
        }

        .presented-to {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin-bottom: 2mm;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .recipient-name {
            text-align: center;
            font-size: 32px;
            color: #3498db;
            font-weight: bold;
            margin: 3mm 0;
            padding-bottom: 2mm;
            border-bottom: 3px solid #3498db;
            letter-spacing: 2px;
        }

        .achievement-text {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin: 4mm 0 3mm;
            line-height: 1.5;
        }

        .course-title-box {
            text-align: center;
            margin: 4mm auto;
            padding: 3mm 6mm;
            background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%);
            border-left: 4px solid #3498db;
            border-right: 4px solid #3498db;
            max-width: 200mm;
        }

        .course-title {
            font-size: 20px;
            color: #1e3a5f;
            font-weight: bold;
            line-height: 1.3;
        }

        /* Course details grid */
        .details-section {
            margin: 5mm 20mm 4mm;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3mm;
        }

        .detail-box {
            background: #f8fafb;
            padding: 3mm;
            border-left: 3px solid #3498db;
            font-size: 9px;
            line-height: 1.5;
        }

        .detail-box strong {
            color: #1e3a5f;
            font-size: 10px;
            display: block;
            margin-bottom: 1mm;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-box p {
            color: #555;
            margin: 0;
        }

        /* Skills section */
        .skills-section {
            margin: 4mm 20mm;
            padding: 3mm;
            background: #f8fafb;
            border: 1px solid #e0e8f0;
        }

        .skills-title {
            font-size: 10px;
            color: #1e3a5f;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2mm;
            letter-spacing: 1px;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2mm;
        }

        .skill-item {
            font-size: 9px;
            color: #555;
            padding-left: 4mm;
            position: relative;
        }

        .skill-item::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #3498db;
            font-weight: bold;
        }

        /* Performance section */
        .performance-section {
            margin: 4mm 20mm;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3mm;
            text-align: center;
        }

        .performance-box {
            background: linear-gradient(135deg, #e8f4f8 0%, #ffffff 100%);
            padding: 2mm;
            border: 1px solid #d0e4f0;
            border-radius: 2mm;
        }

        .performance-label {
            font-size: 8px;
            color: #7f8c8d;
            text-transform: uppercase;
            margin-bottom: 1mm;
            letter-spacing: 0.5px;
        }

        .performance-value {
            font-size: 14px;
            color: #1e3a5f;
            font-weight: bold;
        }

        /* Footer section */
        .footer {
            position: absolute;
            bottom: 18mm;
            left: 20mm;
            right: 20mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-block {
            text-align: center;
            width: 70mm;
        }

        .signature-line {
            border-top: 2px solid #1e3a5f;
            margin-bottom: 2mm;
            padding-top: 8mm;
        }

        .signature-title {
            font-size: 10px;
            color: #1e3a5f;
            font-weight: 600;
            margin-bottom: 1mm;
        }

        .signature-name {
            font-size: 9px;
            color: #7f8c8d;
        }

        /* Certificate info */
        .certificate-info {
            position: absolute;
            bottom: 10mm;
            left: 20mm;
            right: 20mm;
            text-align: center;
            font-size: 8px;
            color: #95a5a6;
            border-top: 1px solid #ecf0f1;
            padding-top: 2mm;
            display: flex;
            justify-content: space-between;
        }

        .certificate-number {
            font-weight: 600;
            color: #7f8c8d;
            letter-spacing: 1px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(52, 152, 219, 0.02);
            font-weight: bold;
            letter-spacing: 8px;
            pointer-events: none;
            z-index: 0;
        }

        /* Seal/Badge */
        .seal {
            position: absolute;
            bottom: 22mm;
            right: 22mm;
            width: 60px;
            height: 60px;
            border: 3px solid #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .seal-content {
            text-align: center;
            font-size: 7px;
            color: #3498db;
            font-weight: bold;
            line-height: 1.2;
        }

        .seal-year {
            font-size: 14px;
            display: block;
            margin-top: 1px;
        }

        /* QR Code */
        .qr-code {
            position: absolute;
            bottom: 22mm;
            left: 22mm;
            width: 55px;
            height: 55px;
            border: 2px solid #e0e8f0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: #bdc3c7;
            text-align: center;
            padding: 3px;
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
            <!-- Border frame -->
            <div class="border-frame"></div>

            <!-- Corner decorations -->
            <div class="corner-decoration top-left"></div>
            <div class="corner-decoration top-right"></div>
            <div class="corner-decoration bottom-left"></div>
            <div class="corner-decoration bottom-right"></div>

            <!-- Watermark -->
            <div class="watermark">EDUCORE</div>

            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <div class="logo">EDUCORE</div>
                    <div class="logo-subtitle">Online Learning Platform</div>
                </div>
                <div class="header-right">
                    <strong>Акредитована освітня платформа</strong>
                    Київ · Україна<br>
                    www.educore.com<br>
                    info@educore.com
                </div>
            </div>

            <!-- Title -->
            <div class="title-section">
                <h1>СЕРТИФІКАТ</h1>
                <p class="subtitle">Certificate of Completion</p>
            </div>

            <!-- Main content -->
            <div class="content">
                <p class="presented-to">Цей сертифікат видається</p>
                <div class="recipient-name">{{ $user->name }}</div>

                <p class="achievement-text">
                    За успішне завершення онлайн-курсу та демонстрацію високого рівня знань,<br>
                    професійних навичок і компетенцій у напрямку
                </p>

                <div class="course-title-box">
                    <div class="course-title">{{ $course->title }}</div>
                </div>
            </div>

            <!-- Course Details -->
            <div class="details-section">
                <div class="detail-box">
                    <strong>Опис програми:</strong>
                    <p>{{ isset($course->description) ? Str::limit($course->description, 120) : 'Комплексна програма навчання, що охоплює теоретичні та практичні аспекти предметної області з акцентом на сучасні методології та інструменти.' }}</p>
                </div>
                <div class="detail-box">
                    <strong>Тривалість навчання:</strong>
                    <p>{{ $duration ?? '40 академічних годин' }}</p>
                    <p style="margin-top: 1mm;"><strong style="font-size: 9px;">Викладач:</strong> {{ $instructor ?? 'Сертифікований інструктор EduCore' }}</p>
                </div>
            </div>

            <!-- Skills Acquired -->
            <div class="skills-section">
                <div class="skills-title">Набуті навички та компетенції:</div>
                <div class="skills-grid">
                    <div class="skill-item">Глибоке розуміння теоретичних основ</div>
                    <div class="skill-item">Практичне застосування знань</div>
                    <div class="skill-item">Аналітичне мислення та вирішення проблем</div>
                    <div class="skill-item">Робота з сучасними інструментами та технологіями</div>
                    <div class="skill-item">Самостійна робота над проектами</div>
                    <div class="skill-item">Критичне мислення та оцінка результатів</div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="performance-section">
                <div class="performance-box">
                    <div class="performance-label">Модулів</div>
                    <div class="performance-value">{{ $modulesCompleted ?? '12' }}</div>
                </div>
                <div class="performance-box">
                    <div class="performance-label">Завдань</div>
                    <div class="performance-value">{{ $assignmentsCompleted ?? '24' }}</div>
                </div>
                <div class="performance-box">
                    <div class="performance-label">Тестів</div>
                    <div class="performance-value">{{ $testsCompleted ?? '8' }}</div>
                </div>
                <div class="performance-box">
                    <div class="performance-label">Оцінка</div>
                    <div class="performance-value">{{ $finalGrade ?? '95%' }}</div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="footer">
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

            <!-- Certificate info -->
            <div class="certificate-info">
                <div class="certificate-number">
                    Сертифікат № {{ $certificateNumber ?? 'EC-' . date('Y') . '-' . str_pad($user->id, 6, '0', STR_PAD_LEFT) . '-' . str_pad($course->id, 4, '0', STR_PAD_LEFT) }}
                </div>
                <div>Дата видачі: {{ $date }}</div>
                <div>Перевірити: educore.com/verify/{{ $certificateNumber ?? '' }}</div>
            </div>

            <!-- QR Code -->
            <div class="qr-code">
                <div>
                    QR<br>CODE<br>
                    <small style="font-size: 6px;">Verify</small>
                </div>
            </div>

            <!-- Official seal -->
            <div class="seal">
                <div class="seal-content">
                    VERIFIED<br>CERTIFICATE
                    <span class="seal-year">{{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
