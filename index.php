<?php
// Incluir los archivos necesarios de la biblioteca de PayU
require_once './vendor/autoload.php';
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Donaciones">
    <meta name="keywords" content="donaciones, payu, pagos">
    <title>Donaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Fondo oscuro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Evita el desplazamiento vertical */
            perspective: 1000px; /* Perspectiva para las animaciones 3D */
        }
        form {
            background-color: rgba(255, 255, 255, 0.1); /* Fondo semitransparente */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1); /* Sombra con efecto de luz */
            max-width: 400px;
            width: 100%;
            position: relative; /* Posicionamiento relativo para el reloj */
            transform-style: preserve-3d; /* Conservar la perspectiva en los elementos hijos */
            animation: floatForm 10s linear infinite alternate; /* Animación de flotar */
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #fff; /* Color del texto */
            animation: fadeIn 2s ease-in-out; /* Animación de aparición */
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        select,
        button {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            outline: none;
            color: #333; /* Color del texto */
            background-color: #f0f0f0; /* Color de fondo del formulario */
            transition: transform 0.5s; /* Transición al enfocar */
            animation: slideIn 2s ease-in-out; /* Animación de deslizamiento */
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        select:focus,
        button:focus {
            transform: scale(1.1); /* Escala al enfocar */
            border-color: #007bff; /* Color del borde al enfocar */
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
            animation: pulse 2s 3 alternate; /* Animación de pulso */
        }
        button:hover {
            background-color: #0056b3;
        }
        .donate-real {
            text-align: center;
            margin-top: 20px;
        }
        .donate-real img {
            max-width: 250px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .donate-real p {
            margin-top: 10px;
            font-size: 14px;
            color: #eee; /* Color del texto */
        }
        #hora_actual {
            margin-top: 20px;
            font-size: 24px; /* Tamaño de fuente grande */
            text-align: center;
            color: #fff; /* Color del texto */
            font-weight: bold;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8); /* Sombra al texto */
            animation: fadeIn 2s ease-in-out; /* Animación de aparición */
        }
        #img {
            max-width: 150px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            animation: rotateImg 10s linear infinite; /* Animación de rotación */
            filter: hue-rotate(180deg) brightness(150%) saturate(150%); /* Filtros de imagen */
            mix-blend-mode: screen; /* Modo de mezcla para efecto de pantalla */
            position: relative;
            top: -20px;
        }
        
        @keyframes rotateImg {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.2); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes slideIn {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(0); }
        }
        @keyframes floatForm {
            0% { transform: translateY(0); }
            100% { transform: translateY(-20px); }
        }
    </style>
<body>
    <form action="src/procesar_pago.php" method="POST">
        <label for="nombre_completo">Nombre Completo:</label>
        <input type="text" id="nombre_completo" name="nombre_completo" required>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>
        
        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required>
        
        <label for="banco">Banco:</label>
        <select id="banco" name="banco" required>
            <?php echo $options; ?>
        </select>
        
        <button type="submit">Donación Ficticia</button>
        
        <div class="donate-real">
            <a href="https://biz.payulatam.com/B0f65017F0BD626" target="_blank">
                <img src="https://ecommerce.payulatam.com/img-secure-2015/boton_pagar_mediano.png" alt="Botón de Donación Real">
            </a>
            <p>¡Haz una diferencia real con tu donación!</p>
        </div>
        
        
    <p id="hora_actual"></p>
    
    <img id="img" data-dis-type="simultaneous">
  
    </form>

    <script>

        function actualizarHora() {
            var ahora = new Date();
            var horas = ahora.getHours().toString().padStart(2, '0');
            var minutos = ahora.getMinutes().toString().padStart(2, '0');
            var segundos = ahora.getSeconds().toString().padStart(2, '0');
            var horaActual = horas + ':' + minutos + ':' + segundos;

            document.getElementById('hora_actual').textContent = 'Hora actual: ' + horaActual;
        }

  
        setInterval(actualizarHora, 1000);
    </script>
</body>
</html>

