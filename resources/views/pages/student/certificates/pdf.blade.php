<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificate</title>
    <style>
        @page {
            margin: 15mm;
        }

        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
        }

        .certificate {
            border: 8px solid #d4af37;
            padding: 30px;
            text-align: center;
            position: relative;
            min-height: 500px;
        }

        .inner-border {
            border: 2px solid #d4af37;
            padding: 40px 30px;
            min-height: 480px;
        }

        .logo {
            width: 45px;
            height: 45px;
            margin: 0 auto 12px auto;
            border-radius: 50%;
            border: 2px solid #d4af37;
            padding: 4px;
        }

        .title {
            font-size: 28px;
            color: #2e7d32;
            font-weight: bold;
            margin: 12px 0 8px 0;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 13px;
            color: #666;
            font-style: italic;
            margin: 10px 0;
        }

        .name {
            font-size: 26px;
            font-weight: bold;
            color: #000;
            margin: 15px 0;
            padding-bottom: 6px;
            border-bottom: 3px double #d4af37;
            display: inline-block;
        }

        .body-text {
            font-size: 14px;
            color: #333;
            margin: 15px 0;
            line-height: 1.6;
        }

        .course-name {
            font-size: 17px;
            color: #2e7d32;
            font-weight: bold;
            font-style: italic;
            margin: 10px 0;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 5px;
        }

        .signature-line {
            width: 100px;
            border-top: 1px solid #000;
            margin: 0 auto 4px auto;
        }

        .signature-img {
            height: 35px;
            margin-bottom: 4px;
        }

        .footer-name {
            font-size: 12px;
            font-weight: bold;
            margin: 4px 0 2px 0;
        }

        .footer-title {
            font-size: 10px;
            color: #666;
            font-style: italic;
        }

        .cert-number {
            font-size: 8px;
            color: #999;
            margin-top: 20px;
        }

        .seal {
            position: absolute;
            bottom: 50px;
            right: 30px;
            width: 50px;
            height: 50px;
            border: 2px solid #d4af37;
            border-radius: 50%;
            background: #d4af37;
            color: white;
            font-size: 6px;
            font-weight: bold;
            line-height: 1.2;
            padding: 16px 4px;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="inner-border">
            @if (!empty($logoBase64))
                <img src="{{ $logoBase64 }}" class="logo" alt="Logo">
            @endif

            <div class="title">CERTIFICATE OF COMPLETION</div>

            <div class="subtitle">This is to certify that</div>

            <div class="name">{{ $user->name }}</div>

            <div class="body-text">
                Has successfully completed the course
                <div class="course-name">"{{ $course->title }}"</div>
                with dedication and commitment to excellence.
            </div>

            <div class="footer">
                <table>
                    <tr>
                        <td>
                            <div class="signature-line"></div>
                            <div class="footer-name">{{ $course->instructor->name ?? 'Instructor' }}</div>
                            <div class="footer-title">Course Instructor</div>
                        </td>
                        <td>
                            @if (!empty($signatureBase64))
                                <img src="{{ $signatureBase64 }}" class="signature-img" alt="Signature">
                            @else
                                <div class="signature-line"></div>
                            @endif
                            <div class="footer-name">Academic Administrator</div>
                            <div class="footer-title">Authorized Signatory</div>
                        </td>
                        <td>
                            <div class="signature-line"></div>
                            <div class="footer-name">{{ $certificate->issued_at->format('d M Y') }}</div>
                            <div class="footer-title">Date of Issue</div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="cert-number">
                Certificate No: {{ $certificate->certificate_number }}
            </div>

            <div class="seal">
                OFFICIAL<br>SEAL
            </div>
        </div>
    </div>
</body>

</html>
