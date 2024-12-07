<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar PHPMailer (composer autoload)
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $consulta = htmlspecialchars(trim($_POST['consulta']));

    // Validar campos
    if (empty($nombre) || empty($email) || empty($consulta)) {
        die("Todos los campos son obligatorios.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("El correo electrónico no es válido.");
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'blancastierras495@gmail.com';
        $mail->Password = 'rwgl qaxp pfqp zkbp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurar destinatarios
        $mail->setFrom('blancastierras495@gmail.com', 'Soporte Tierras Blancas');
        $mail->addAddress('blancastierras495@gmail.com');
        $mail->addReplyTo($email, $nombre);

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = "Nueva Consulta de $nombre"; 
        $mail->Body = "Nombre: $nombre\nCorreo: $email\nConsulta:\n$consulta";

        // Enviar correo
        $mail->send();
        echo "Consulta enviada correctamente. Nos pondremos en contacto contigo pronto.";
        echo "<a href='index.html'>Volver al inicio</a><br>";
echo "<a href='contactos.html'>Realizar otra consulta</a>";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "Acceso no autorizado.";
}
?>
