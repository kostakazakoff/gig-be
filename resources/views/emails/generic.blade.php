<!DOCTYPE html>
<html lang="{{ $language === 'bg' ? 'bg' : 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', "GIG") }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .message {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            font-size: 12px;
            color: #666;
        }
        .contact-info {
            margin-top: 15px;
        }
        .contact-info a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 class="logo">{{ env('APP_NAME', "GIG") }}</h1>
        </div>

        <div class="content">
            <p>{{ $language === 'BG' ? 'Здравейте,' : 'Hello,' }}</p>

            <div class="message">
                {!! nl2br(e($messageContent)) !!}
            </div>

            <p>
                {{ $language === 'BG' ? 'С уважение,' : 'Best regards,' }}<br>
                {{ $language === 'BG' ? 'Екипът на GIG Construct' : 'The GIG Construct Team' }}
            </p>
        </div>

        <div class="footer">
            <div class="contact-info">
                <p>
                    <strong>{{ config('mail.from.name') }}</strong><br>
                    Email: <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a><br>
                    {{ $language === 'BG' 
                        ? 'Този имейл е изпратен автоматично, моля не отговаряйте директно.' 
                        : 'This email was sent automatically, please do not reply directly.' 
                    }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
