<?php
require_once '../lib/PayU.php';


// Configuración de credenciales de producción proporcionadas por PayU
PayU::$apiKey = "4Vj8eK4rloUd272L48hsrarnUA"; // API Key de producción
PayU::$apiLogin = "pRRXKOl8ikMmt9u"; // API Login de producción
PayU::$merchantId = "508029"; // Merchant ID de producción
PayU::$language = SupportedLanguages::ES; // Idioma utilizado para mensajes de error
PayU::$isTest = true; // Cambia a false si estás en modo producción

$linkpruebas = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
$reportpruebas = "https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi";

Environment::setPaymentsCustomUrl($linkpruebas);
Environment::setReportsCustomUrl($reportpruebas);

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
                "accountId" => "512321",
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
                "dniNumber" => "123456789",
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
            "creditCard" => [
                "number" => "4097440000000004",
                "securityCode" => "321",
                "expirationDate" => "2025/12",
                "name" => "APPROVED"
            ],
            "extraParameters" => [
                "INSTALLMENTS_NUMBER" => 1
            ],
            "type" => "AUTHORIZATION_AND_CAPTURE",
            "paymentMethod" => "VISA",
            "paymentCountry" => "CO",
            "deviceSessionId" => $deviceSessionId,
            "ipAddress" => $_SERVER['REMOTE_ADDR'],
            "cookie" => session_id(),
            "userAgent" => $_SERVER['HTTP_USER_AGENT']
        ],
        "test" => true
    ];

    $json_data = json_encode($data);

    $options = [
        CURLOPT_URL => $linkpruebas,
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

    curl_close($curl);

    // Convertir la respuesta de la API a un array para facilitar su manipulación
    $response_data = json_decode($response, true);
        // Mostrar los datos de la transacción (para propósitos de depuración)
        //echo "<h2>Datos de la transacción:</h2>";
        //echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
} else {
    header("Location: index.html");
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content {
            margin-bottom: 25px;
            animation: slideIn 1s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .json-output {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            white-space: pre-wrap;
            font-family: 'Courier New', Courier, monospace;
            animation: fadeIn 1s ease-out;
            overflow-y: auto;
            max-height: 200px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }

        .back-link {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 18px;
            text-decoration: none;
            transition: color 0.3s;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .back-link:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="title">Transacción Aprobada</div>
    <div class="content"><strong>Nombre:</strong> <?php echo $nombre_completo ?></div>
    <div class="content"><strong>Correo:</strong> <?php echo $correo ?> </div>
    <div class="content"><strong>Respuesta de la API:</strong></div>
    <div class="content">Se te enviará un correo con la transacción.</div>
    <div class="content"><strong>Datos de la transacción:</strong></div>
    <div class="json-output">
        <?php echo $json_data; ?>
    </div>
    <div class="content"><strong>Resultado de la transacción:</strong></div>
    <div class="json-output">
        <?php echo $response; ?>
    </div>
    <a class="back-link" href="/index.php">Volver al formulario</a>
</div>

</body>
</html>


