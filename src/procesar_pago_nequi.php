<?php

require_once '../vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreCompleto = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $monto = $_POST['monto'];

    // Validar los datos recibidos
    if (!empty($nombreCompleto) && !empty($correo) && !empty($telefono) && !empty($monto)) {
        // Guardar los datos en la sesión para usarlos en la página de confirmación
        session_start();
        $_SESSION['nombre_completo'] = $nombreCompleto;
        $_SESSION['correo'] = $correo;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['monto'] = $monto;

        // Redirigir a la página de confirmación
        header("Location: procesar_pago.php");
        exit();
    } else {
        echo "Todos los campos son requeridos.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
