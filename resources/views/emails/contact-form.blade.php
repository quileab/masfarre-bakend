<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body>
    <h1>Nuevo Mensaje de Contacto</h1>
    <p><strong>Nombre:</strong> {{ $data['fullname'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $data['phone'] }}</p>
    <p><strong>Fecha del Evento:</strong> {{ $data['eventdate'] }}</p>
    <p><strong>Tipo de Evento:</strong> {{ $data['eventtype'] }}</p>
    <p><strong>Lugar del Evento:</strong> {{ $data['eventplace'] }}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>
