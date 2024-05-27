<?php
require_once '[PayU-php-sdk-Path]/lib/PayU.php';

class Pay {
    public function __construct() {
        PayU::$apiKey = "xxxxxxxxxxxx"; // Ingresa tu llave API aquí
        PayU::$apiLogin = "xxxxxxxxxxxx"; // Ingresa tu API login aquí
        PayU::$merchantId = "1"; // Enter your Merchant Id here
        PayU::$language = SupportedLanguages::ES; // Ingresa aquí el idioma
        PayU::$isTest = false; // asigna true si estás en modo pruebas
    }
}




?>