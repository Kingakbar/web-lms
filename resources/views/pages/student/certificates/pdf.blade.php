<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
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
            font-family: 'Arial', 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        .page-wrapper {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: white;
        }

        /* Decorative borders */
        .border-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 15mm;
            background: #1e3a5f;
        }

        .border-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 15mm;
            background: #1e3a5f;
        }

        .border-left {
            position: absolute;
            top: 15mm;
            left: 0;
            bottom: 15mm;
            width: 15mm;
            background: #1e3a5f;
        }

        .border-right {
            position: absolute;
            top: 15mm;
            right: 0;
            bottom: 15mm;
            width: 15mm;
            background: #17a2b8;
        }

        /* Corner accents */
        .corner-accent {
            position: absolute;
            width: 30mm;
            height: 30mm;
            background: #17a2b8;
        }

        .corner-top-left {
            top: 0;
            left: 0;
        }

        .corner-bottom-right {
            bottom: 0;
            right: 0;
        }

        /* Main content area */
        .certificate-container {
            position: absolute;
            top: 15mm;
            left: 15mm;
            right: 15mm;
            bottom: 15mm;
            background: white;
            padding: 30px 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container {
            margin-bottom: 10px;
        }

        .logo {
            height: 50px;
            width: auto;
            max-width: 180px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 800;
            color: #1e3a5f;
            letter-spacing: -0.5px;
        }

        .logo-accent {
            color: #17a2b8;
        }

        .certificate-title {
            text-align: center;
            margin: 20px 0 5px 0;
        }

        .certificate-title h1 {
            font-size: 42px;
            font-weight: 900;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 3px;
            position: relative;
            display: inline-block;
        }

        .title-underline {
            width: 200px;
            height: 4px;
            background: #ffd700;
            margin: 0 auto;
        }

        .cert-number {
            text-align: center;
            font-size: 9px;
            color: #666;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .content {
            text-align: center;
            margin-top: 25px;
        }

        .certify-text {
            font-size: 12px;
            color: #333;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-size: 30px;
            font-weight: 700;
            color: #1e3a5f;
            margin: 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px dashed #17a2b8;
            display: inline-block;
        }

        .participation-text {
            font-size: 12px;
            color: #333;
            margin: 15px 0 10px 0;
        }

        .course-name {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a5f;
            margin: 10px 0 15px 0;
            line-height: 1.3;
        }

        .course-date {
            font-size: 11px;
            color: #666;
            margin-bottom: 30px;
        }

        .footer {
            margin-top: 35px;
            display: table;
            width: 100%;
        }

        .footer-left,
        .footer-right {
            display: table-cell;
            vertical-align: bottom;
        }

        .footer-left {
            width: 60%;
            text-align: center;
        }

        .footer-right {
            width: 40%;
            text-align: center;
        }

        .location-date {
            font-size: 11px;
            color: #333;
            margin-bottom: 5px;
        }

        .signature-line {
            width: 130px;
            height: 50px;
            margin: 0 auto;
            display: block;
        }

        .signature-image {
            max-width: 120px;
            max-height: 45px;
            height: auto;
        }

        .signature-placeholder {
            width: 120px;
            height: 1px;
            background: #333;
            margin: 25px auto 5px auto;
        }

        .signature-name {
            font-size: 12px;
            font-weight: 700;
            color: #1e3a5f;
            margin-top: 5px;
        }

        .signature-title {
            font-size: 9px;
            color: #666;
        }

        .qr-section {
            display: inline-block;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            border: 2px solid #1e3a5f;
            margin: 0 auto 5px auto;
            background: #f5f5f5;
        }

        .qr-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: #666;
            text-align: center;
            padding: 5px;
        }

        .qr-logo {
            font-size: 13px;
            font-weight: 700;
            color: #1e3a5f;
        }

        .qr-logo-accent {
            color: #17a2b8;
        }

        .verification-link {
            position: absolute;
            bottom: 20px;
            left: 40px;
            font-size: 7px;
            color: #17a2b8;
        }

        /* Decorative elements */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .deco-circle-1 {
            width: 150px;
            height: 150px;
            background: #17a2b8;
            top: 30px;
            right: 50px;
        }

        .deco-circle-2 {
            width: 120px;
            height: 120px;
            background: #1e3a5f;
            bottom: 40px;
            left: 60px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <!-- Borders -->
        <div class="corner-accent corner-top-left"></div>
        <div class="corner-accent corner-bottom-right"></div>
        <div class="border-top"></div>
        <div class="border-bottom"></div>
        <div class="border-left"></div>
        <div class="border-right"></div>

        <!-- Main Content -->
        <div class="certificate-container">
            <!-- Decorative circles -->
            <div class="deco-circle deco-circle-1"></div>
            <div class="deco-circle deco-circle-2"></div>

            <div class="header">
                @if (!empty($logoBase64))
                    <div class="logo-container">
                        <img src="{{ $logoBase64 }}" class="logo" alt="TechnestAcademy Logo">
                    </div>
                @else
                    <div class="logo-text">
                        Technest<span class="logo-accent">Academy</span>
                    </div>
                @endif
            </div>

            <div class="certificate-title">
                <h1>CERTIFICATE</h1>
            </div>
            <div class="title-underline"></div>

            <div class="cert-number">
                Certificate No: {{ $certificate->certificate_number }}
            </div>

            <div class="content">
                <div class="certify-text">
                    This is to certify that
                </div>

                <div class="recipient-name">
                    {{ $user->name }}
                </div>

                <div class="participation-text">
                    has successfully completed the course
                </div>

                <div class="course-name">
                    {{ $course->title }}
                </div>

                <div class="course-date">
                    Issued on {{ $certificate->issued_at->format('F d, Y') }} by TechnestAcademy
                </div>
            </div>

            <div class="footer">
                <div class="footer-left">
                    <div class="location-date">
                        Medan, {{ $certificate->issued_at->format('F Y') }}
                    </div>
                    @if (!empty($signatureBase64))
                        <div class="signature-line">
                            <img src="{{ $signatureBase64 }}" class="signature-image" alt="Signature">
                        </div>
                    @else
                        <div class="signature-placeholder"></div>
                    @endif
                    <div class="signature-name">Wahyu Riansyah, S.Kom., M.Kom.</div>
                    <div class="signature-title">CEO JALINTEK</div>
                </div>

                <div class="footer-right">


                    <div class="qr-logo">
                        Technest<span class="qr-logo-accent">Academy</span>
                    </div>

                </div>
            </div>


        </div>
    </div>
</body>

</html>
