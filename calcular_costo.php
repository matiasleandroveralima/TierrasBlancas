<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Obtener los datos del cálculo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cantidad = $_POST['cantidad'];
    $dia = $_POST['dia'];
    $fecha = $_POST['fecha']; // Obtener la fecha seleccionada

    // Validar los campos
    if (empty($cantidad) || empty($dia) || empty($fecha)) {
        die("Todos los campos son obligatorios.");
    }

    // Definir precios
    $precio_entre_semana = 2000;
    $precio_fin_de_semana = 2500;

    // Calcular el costo total y aplicar el descuento
    if ($dia == 'entre_semana') {
        $costo_base = $cantidad * $precio_entre_semana;
        $descuento = $costo_base * 0.15; // 15% de descuento
        $costo_total = $costo_base - $descuento;
        $mensaje = "Es un día entre semana. Se aplicó un 15% de descuento.";
    } elseif ($dia == 'fin_de_semana') {
        $costo_base = $cantidad * $precio_fin_de_semana;
        $descuento = $costo_base * 0.10; // 10% de descuento
        $costo_total = $costo_base - $descuento;
        $mensaje = "Es un fin de semana. Se aplicó un 10% de descuento.";
    }
} else {
    header('Location: costo_entradas.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Cálculo</title>
    <link rel="stylesheet" href="stylesForm.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
            text-align: center;
        }

        header {
            margin-bottom: 20px;
        }

        .resultado {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 600px;
            text-align: left;
        }

        .resultado h1 {
            color: #333;
        }

        .botones {
            margin-top: 20px;
        }

        .botones a, .botones form button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .botones a:hover, .botones form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>
        <form action="logout.php" method="POST" style="display:inline;">
            <button type="submit">Cerrar Sesión</button>
        </form>
    </header>

    <div class="resultado">
        <h1>Resultado</h1>
        <p><?php echo $mensaje; ?></p>
        <p>Fecha seleccionada: <?php echo htmlspecialchars($fecha); ?></p>
        <p>Cantidad de personas: <?php echo $cantidad; ?></p>
        <p>Costo base: $<?php echo number_format($costo_base, 2); ?></p>
        <p>Descuento aplicado: $<?php echo number_format($descuento, 2); ?></p>
        <p>Total a pagar: $<?php echo number_format($costo_total, 2); ?></p>
    </div>

    <div class="botones">
        <a href="costo_entradas.html">Regresar al formulario</a>
    </div>
</body>
</html>