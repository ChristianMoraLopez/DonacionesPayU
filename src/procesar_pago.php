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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lobster&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, #ece9e6, #ffffff);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
    }

    .container {
        display: flex;
        flex-direction: row;
        max-width: 900px;
        width: 100%;
        margin: 20px;
        background-color: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeIn 1.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .container:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .left-column, .right-column {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .left-column {
        flex: 3;
        background: linear-gradient(135deg, #ff6f61, #de6262);
        color: white;
        padding: 60px;
        position: relative;
        overflow: hidden;
    }

    .left-column::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
        transform: rotate(-30deg);
    }

    .right-column {
        flex: 2;
        background-color: #f1f1f1;
        border-left: 2px solid #eee;
        text-align: center;
        position: relative;
    }

    .right-column::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f1f1f1, #e1e1e1);
        transform: skewX(-10deg);
        z-index: -1;
    }

    .title {
        font-family: 'Lobster', cursive;
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #fff;
        text-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
        animation: fadeInTitle 1s ease 0.5s forwards;
        opacity: 0;
    }

    @keyframes fadeInTitle {
        to {
            opacity: 1;
        }
    }

    .important {
        color: #ffeb3b;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 20px;
    }

    .payment-method {
        font-size: 24px;
        font-weight: 500;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        animation: fadeInUp 1s ease 1s forwards;
        opacity: 0;
    }

    .payment-method img {
        margin-left: 10px;
        width: 50px;
        height: auto;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .instructions {
        margin-top: 30px;
        font-size: 18px;
        color: #fff;
    }

    .instructions p {
        margin-bottom: 10px;
        font-weight: 500;
    }

    .instructions ol {
        padding-left: 20px;
        list-style: none;
    }

    .instructions li {
        margin-bottom: 15px;
        padding-left: 50px;
        position: relative;
        font-weight: 400;
    }

    .instructions li::before {
        content: "";
        width: 30px;
        height: 30px;
        background-size: cover;
        background-repeat: no-repeat;
        display: inline-block;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    .instructions li:nth-child(1)::before {
        background-image: url('images/nequi.svg');
    }

    .instructions li:nth-child(2)::before {
        background-image: url('images/notificación.svg');
    }

    .instructions li:nth-child(3)::before {
        background-image: url('images/correo.svg');
    }

    .back-link {
        display: inline-block;
        margin-top: 40px;
        text-decoration: none;
        font-size: 20px;
        color: #3498db;
        background-color: #fff;
        padding: 15px 30px;
        border-radius: 50px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, box-shadow 0.3s, transform 0.3s;
        animation: fadeInUp 1s ease 1.2s forwards;
        opacity: 0;
    }

    .back-link:hover {
        background-color: #2980b9;
        color: #fff;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .summary {
        margin-top: 20px;
        color: #555;
        animation: fadeInRight 1s ease 0.5s forwards;
        opacity: 0;
    }

    .summary p {
        margin: 15px 0;
        font-size: 20px;
        font-weight: 500;
    }

    .summary p strong {
        color: #333;
    }

    @keyframes fadeInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .summary p::before {
        content: "\f058";
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-right: 10px;
        color: #3498db;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .left-column, .right-column {
            padding: 20px;
        }

        .left-column {
            padding: 40px 20px;
        }

        .title {
            font-size: 32px;
        }

        .important {
            font-size: 18px;
        }

        .payment-method {
            font-size: 20px;
        }

        .instructions {
            font-size: 16px;
        }

        .back-link {
            font-size: 18px;
            padding: 10px 20px;
        }

        .summary p {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .left-column, .right-column {
            padding: 10px;
        }

        .left-column {
            padding: 20px 10px;
        }

        .title {
            font-size: 24px;
        }

        .important {
            font-size: 16px;
        }

        .payment-method {
            font-size: 18px;
        }

        .instructions {
            font-size: 14px;
        }

        .back-link {
            font-size: 16px;
            padding: 8px 16px;
        }

        .summary p {
            font-size: 16px;
        }
    }
</style>

</head>

<body>
    <div class="container">
        <div class="left-column">
            <div class="title">Transacción Aprobada</div>
            <p>Hola <strong><?php echo $nombre_completo; ?></strong>, tu transacción ha sido aprobada. Gracias por tu donación.</p>
            <p class="important">Importante: tienes 35 minutos para aprobar tu pago</p>
            <p class="payment-method">Medio de pago:
                <img src="images/Nequi_id-T1XPwUY_1.svg" alt="Nequi">
            </p>
            <p>Nombre: <?php echo $nombre_completo; ?></p>
            <p>Teléfono: <?php echo $telefono; ?></p>
            <p>Por favor, sigue las instrucciones que te llegaron a tu celular para completar tu pago.</p>
            <div class="instructions">
                <p>Instrucciones:</p>
                <ol>
                    <li>
                        Abre la aplicación Nequi en tu celular
                    </li>
                    <li>
                        Revisa las notificaciones de la aplicación para confirmar el pago.
                    </li>
                    <li>
                        Recibe la confirmación en tu correo electrónico
                    </li>
                </ol>
            </div>
            <a class="back-link" href="../index.php">Volver al formulario</a>
        </div>
        <div class="right-column">
            <p>Resumen de la transacción:</p>
            <div class="summary">
                <p><strong>Estado:</strong> <?php echo $response; ?></p>
                <p><strong>Valor:</strong> <?php echo $monto; ?></p>
            </div>
        </div>
    </div>
</body>

</html>
