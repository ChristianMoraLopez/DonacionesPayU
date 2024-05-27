<?php
// Incluye los archivos necesarios de la biblioteca de PayU
require_once '../lib/PayU.php'; // Asegúrate de actualizar este camino a donde tienes las librerías de PayU
require_once '../vendor/autoload.php'; 

// Configuración de credenciales de prueba proporcionadas por PayU
PayU::$apiKey = "4Vj8eK4rloUd272L48hsrarnUA"; // API Key de prueba
PayU::$apiLogin = "pRRXKOl8ikMmt9u"; // API Login de prueba
PayU::$merchantId = "508029"; // Merchant ID de prueba
PayU::$language = SupportedLanguages::ES; // Idioma utilizado para mensajes de error
PayU::$isTest = true; // Asigna true si estás en modo pruebas

// URL del entorno de sandbox de PayU
Environment::setPaymentsCustomUrl("https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi");

// Habilitar el informe de errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Parámetros para obtener la lista de bancos PSE
$parameters = array(
    PayUParameters::PAYMENT_METHOD => "PSE", // Método de pago
    PayUParameters::COUNTRY => PayUCountries::CO // País (Colombia en este caso)
);

try {
    // Llama al método para obtener la lista de bancos
    $response = PayUPayments::getPSEBanks($parameters);

    // Verificar si hay un error en la respuesta
    if ($response->code !== 'SUCCESS') {
        echo "Error: " . $response->error . "<br>";
        echo "Descripción del error: " . $response->description . "<br>";
    } else {
        // Verifica si la respuesta contiene los bancos
        if (isset($response->banks)) {
            $banks = $response->banks;

            // Recorre y muestra la lista de bancos
            foreach ($banks as $bank) {
                echo "Descripción del Banco: " . $bank->description . "<br>";
                echo "Código PSE: " . $bank->pseCode . "<br><br>";
            }
        } else {
            echo "No se encontraron bancos disponibles.";
        }
    }
} catch (Exception $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}
?>
