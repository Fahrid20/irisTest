<!DOCTYPE html>
<html>
<head>
    <title>Message de Contact</title>
</head>
<body>
    <h2>Nouveau message reçu</h2>
    <p><strong>Nom :</strong> {{ $details['name'] }}</p>
    <p><strong>Email :</strong> {{ $details['email'] }}</p>
    <p><strong>Message :</strong></p>
    <p>{{ $details['message'] }}</p>
</body>
</html>
