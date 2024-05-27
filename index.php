<?php
// Incluir los archivos necesarios de la biblioteca de PayU
require_once './lib/PayU.php'; // Asegúrate de actualizar este camino a donde tienes las librerías de PayU

// Configuración de credenciales de producción proporcionadas por PayU
PayU::$apiKey = "4Vj8eK4rloUd272L48hsrarnUA"; // API Key de producción
PayU::$apiLogin = "pRRXKOl8ikMmt9u"; // API Login de producción
PayU::$merchantId = "508029"; // Merchant ID de producción
PayU::$language = SupportedLanguages::ES; // Idioma utilizado para mensajes de error
PayU::$isTest = true; // Cambia a false si estás en modo producción

// Configurar las URLs para el ambiente de producción
$linkpruebas = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
$reportpruebas = "https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi";

Environment::setPaymentsCustomUrl($linkpruebas);
Environment::setReportsCustomUrl($reportpruebas);

// Parámetros para la consulta de bancos PSE
$parameters = array(
    // Ingresa aquí el nombre del método de pago.
    PayUParameters::PAYMENT_METHOD => "PSE",
    // Ingresa aquí el nombre del país.
    PayUParameters::COUNTRY => PayUCountries::CO,
);

// Consulta de bancos PSE
$array = PayUPayments::getPSEBanks($parameters);
$banks = $array->banks;

// Generar opciones para el select de bancos
$options = '';
foreach ($banks as $bank) {
    $options .= '<option value="' . $bank->pseCode . '">' . $bank->description . '</option>';
}

// Consultar métodos de pago disponibles
$array = PayUPayments::getPaymentMethods();
$payment_methods = $array->paymentMethods;

foreach ($payment_methods as $payment_method) {
    $payment_method->country;
    $payment_method->description;
    $payment_method->id;
}
?>

<!DOCTYPE html>
<html lang = "es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Donaciones">
    <meta name="keywords" content="donaciones, payu, pagos">
    <script src="./html2canvas.min.js"></script>
    <script src="./disintegrate.js"></script>
<head>
    <title>Donaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }

        #img{
           display: none;
            height: 100px;
            width: 100px;
            background-image: url('https://christianmoralopez.github.io/images/Logo3White.svg');
            background-size: cover;
            background-position: center;
        }

    </style>
</head>
<body>
    <form action="src/procesar_pago.php" method="POST">
        <label for="nombre_completo">Nombre Completo:</label>
        <input type="text" id="nombre_completo" name="nombre_completo" required><br>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br>
        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required><br>
        <label for="banco">Banco:</label>
        <select id="banco" name="banco" required>
            <?php echo $options; ?>
        </select>
        <!-- Mostrar la hora actual -->
        <p id="hora_actual"></p>
        <button type="submit">Donar</button>
        <a href="https://biz.payulatam.com/B0f65017F0BD626"><img src="https://ecommerce.payulatam.com/img-secure-2015/boton_pagar_mediano.png"></a>
        <img  id="img" data-dis-type="simultaneous">
    </form>

    <!-- Script para actualizar la hora -->
    <script>

        disintegrate.init();
    function actualizarHora() {
        var ahora = new Date();
        var horas = ahora.getHours().toString().padStart(2, '0');
        var minutos = ahora.getMinutes().toString().padStart(2, '0');
        var segundos = ahora.getSeconds().toString().padStart(2, '0');
        var horaActual = horas + ':' + minutos + ':' + segundos;

        document.getElementById('hora_actual').textContent = 'Hora actual: ' + horaActual;
       
    }

    

    document.getElementById('img').addEventListener('click', e => {
        const disObj = disintegrate.getDisObj(e.target);
        disintegrate.createSimultaneousParticles(disObj);
    });

    // Actualizar la hora cada segundo
    setInterval(actualizarHora, 1000);
</script>


</body>
</html>
