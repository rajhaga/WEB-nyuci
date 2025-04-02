<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak Baru</title>
</head>
<body>
    <h2>Pesan Baru dari Contact Form</h2>
    
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Telepon:</strong> {{ $data['phone'] }}</p>
    <p><strong>Pesan:</strong></p>
    <p>{{ $data['message'] }}</p>
    
    <hr>
    <p>Email ini dikirim secara otomatis, harap tidak membalas email ini.</p>
</body>
</html>