<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pesan Baru dari Contact Form</h2>
        
        <p><strong>Nama:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Telepon:</strong> {{ $phone ?? 'Tidak dicantumkan' }}</p>
        <p><strong>Pesan:</strong></p>
        <p>{{ $messageContent }}</p>
        
        <hr>
        <div class="footer">
            <p>Email ini dikirim secara otomatis, harap tidak membalas email ini.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>