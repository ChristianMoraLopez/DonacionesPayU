<?php
require_once '../vendor/autoload.php';
require_once '../lib/PayU.php';

// Configuración de credenciales de producción proporcionadas por PayU
PayU::$apiKey = "tsG2CYzQLRDpQhkj6wmj6h5siZ"; // API Key de producción
PayU::$apiLogin = "5poAbwFB9ewb47Y"; // API Login de producción
PayU::$merchantId = "1008897"; // Merchant ID de producción
PayU::$language = SupportedLanguages::ES; // Idioma utilizado para mensajes de error
PayU::$isTest = false; // Cambia a false si estás en modo producción

// Configurar las URLs para el ambiente de producción
$linkproduccion = "https://api.payulatam.com/payments-api/4.0/service.cgi";
$reportproduccion = "https://api.payulatam.com/reports-api/4.0/service.cgi";
Environment::setPaymentsCustomUrl($linkproduccion);
Environment::setReportsCustomUrl($reportproduccion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST["nombre_completo"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $monto = $_POST["monto"];

    $deviceSessionId = md5(session_id() . microtime());
    $referenceCode = "ORDEN" . time();
    $signature = md5(PayU::$apiKey . "~" . PayU::$merchantId . "~" . $referenceCode . "~" . $monto . "~COP");

    $data = [
        "language" => "es",
        "command" => "SUBMIT_TRANSACTION",
        "merchant" => [
            "apiKey" => PayU::$apiKey,
            "apiLogin" => PayU::$apiLogin
        ],
        "transaction" => [
            "order" => [
                "accountId" => "1017706",
                "referenceCode" => $referenceCode,
                "description" => "Pago de donación",
                "language" => "es",
                "signature" => $signature,
                "notifyUrl" => "http://www.tusitio.com/confirmation",
                "additionalValues" => [
                    "TX_VALUE" => [
                        "value" => $monto,
                        "currency" => "COP"
                    ]
                ],
                "buyer" => [
                    "merchantBuyerId" => "1",
                    "fullName" => $nombre_completo,
                    "emailAddress" => $correo,
                    "contactPhone" => $telefono,
                    "dniNumber" => "123456789",
                    "shippingAddress" => [
                        "street1" => "Calle 93B",
                        "street2" => "17 25",
                        "city" => "Bogotá",
                        "state" => "Bogotá DC",
                        "country" => "CO",
                        "postalCode" => "000000",
                        "phone" => $telefono
                    ]
                ]
            ],
            "payer" => [
                "merchantPayerId" => "1",
                "fullName" => $nombre_completo,
                "emailAddress" => $correo,
                "contactPhone" => $telefono,
                "dniNumber" => "1018441569",
                "billingAddress" => [
                    "street1" => "Calle 93B",
                    "street2" => "17 25",
                    "city" => "Bogotá",
                    "state" => "Bogotá DC",
                    "country" => "CO",
                    "postalCode" => "000000",
                    "phone" => $telefono
                ]
            ],
            "type" => "AUTHORIZATION_AND_CAPTURE",
            "paymentMethod" => "NEQUI",
            "paymentCountry" => "CO",
            "deviceSessionId" => $deviceSessionId,
            "ipAddress" => $_SERVER['REMOTE_ADDR'],
            "cookie" => session_id(),
            "userAgent" => $_SERVER['HTTP_USER_AGENT']
        ],
        "test" => false
    ];

    $json_data = json_encode($data);

    $options = [
        CURLOPT_URL => $linkproduccion,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Content-Length: " . strlen($json_data)
        ],
        CURLOPT_RETURNTRANSFER => true
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);

    if ($response === false) {
        die("Error de conexión: " . curl_error($curl));
    }

    
// Verifica si la respuesta contiene "SUCCESS"
if (strpos($response, 'SUCCESS') !== false) {
    $response = "SUCCESS";

} else {
    $response = "ERROR";
}

    curl_close($curl);

    // Convertir la respuesta de la API a un array para facilitar su manipulación
    $response_data = json_decode($response, true);
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta de Transacción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .left-column {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .left-column p {
            margin: 10px 0;
            font-size: 18px;
        }
        .right-column {
            padding: 20px;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .important {
            color: #f00;
            font-weight: bold;
        }
        .payment-method {
            font-size: 20px;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
        }
        .instructions {
            margin-top: 20px;
            font-size: 16px;
        }
        .instructions p {
            margin: 10px 0;
        }
        .summary {
            margin-top: 20px;
        }
        .summary p {
            margin: 10px 0;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left-column">
        <p>Resumen de la transacción:</p>
        <p>Estado: <?php echo $estado_transaccion; ?></p>
        <p>Valor: <?php echo $monto; ?></p>
    </div>
    <div class="right-column">
        <div class="title">Transacción Aprobada</div>
        <p>Hola <strong><?php echo $nombre_completo; ?></strong>, tu transacción ha sido aprobada. A continuación, gracias por tu donación.</p>
        <p class="important">Importante: tienes 35 minutos para aprobar tu pago</p>
        <p class="payment-method">Medio de pago: Nequi</p>
        <p>Nombre: <?php echo $nombre_completo; ?></p>
        <p>Teléfono: <?php echo $telefono; ?></p>
        <p>Por favor, sigue las instrucciones que te llegaron a tu celular para completar tu pago.</p>
        <div class="instructions">
            <p>Instrucciones:</p>
            <ol>
                <li>Abre la aplicación Nequi en tu celular</li>
                <li>Revisa las notificaciones de la aplicación para confirmar el pago.</li>
                <li>Recibe la confirmación en tu correo electrónico</li>
            </ol>
        </div>
        <a class="back-link" href="/index.php">Volver al formulario</a>
    </div>
</div>

</body>
</html>

