<?php
$reference = "payment_test_00000001";

$value = "65000";



$parameters = array(

	//Ingresa aquí el identificador de la cuenta

	PayUParameters::ACCOUNT_ID => "512325",

	// Ingresa aquí la referencia de pago.

	PayUParameters::REFERENCE_CODE => $reference,

	// Ingresa aquí la descripción del pago.

	PayUParameters::DESCRIPTION => "payment test",



	// -- Valores --

        //Ingresa aquí el valor.

	PayUParameters::VALUE => $value,

  // Ingresa el valor del IVA (Impuesto al valor agregado válido únicamente en Colombia) de la transacción,

  // Si no se envía IVA, ell sistema aplica el 19% automáticamente. Puede contener dos dígitos decimales

  // Ejemplo 19000.00. En caso de ser exento de IVA, asigna 0.

  PayUParameters::TAX_VALUE => "10378",

  // Ingresa el valor base sobre el que se calcula el IVA (válido únicamente en Colombia).

  // En caso de ser exento de IVA, asigna 0.

  PayUParameters::TAX_RETURN_BASE => "54622",

	// Ingresa aquí la moneda.

	PayUParameters::CURRENCY => "COP",



	// -- Comprador --

	// Ingresa aquí el identificador del comprador.

	PayUParameters::BUYER_ID => "1",

	// Ingresa aquí el nombre del comprador.

	PayUParameters::BUYER_NAME => "First name and second buyer name",

	// Ingresa aquí el correo electrónico del comprador.

	PayUParameters::BUYER_EMAIL => "buyer_test@test.com",

	// Ingresa aquí el teléfono de contacto del comprador.

	PayUParameters::BUYER_CONTACT_PHONE => "7563126",

	// Ingresa aquí el número de identificación del comprador.

	PayUParameters::BUYER_DNI => "5415668464654",

	// Ingresa aquí la dirección del comprador.

	PayUParameters::BUYER_STREET => "Cr 23 No. 53-50",

	PayUParameters::BUYER_STREET_2 => "5555487",

	PayUParameters::BUYER_CITY => "BOGOTÁ",

	PayUParameters::BUYER_STATE => "Bogotá D.C",

	PayUParameters::BUYER_COUNTRY => "CO",

	PayUParameters::BUYER_POSTAL_CODE => "000000",

	PayUParameters::BUYER_PHONE => "7563126",





	// -- Pagador --

	// Ingresa aquí el identificador del pagador.

	PayUParameters::PAYER_ID => "1",

        /// Ingresa aquí el nombre del pagador

	PayUParameters::PAYER_NAME => "First name and second payer name",

	// Ingresa aquí el correo electrónico del pagador

	PayUParameters::PAYER_EMAIL => "payer_test@test.com",

	// Ingresa aquí el número de teléfono del pagador.

	PayUParameters::PAYER_CONTACT_PHONE => "7563126",

	// Ingresa aquí el número de identificación del pagador.

	PayUParameters::PAYER_DNI => "5415668464654",

	// Ingresa aquí la dirección del pagador.

	PayUParameters::PAYER_STREET => "Cr 23 No. 53-50",

	PayUParameters::PAYER_STREET_2 => "5555487",

	PayUParameters::PAYER_CITY => "BOGOTÁ",

	PayUParameters::PAYER_STATE => "Bogotá D.C",

	PayUParameters::PAYER_COUNTRY => "CO",

	PayUParameters::PAYER_POSTAL_CODE => "000000",

	PayUParameters::PAYER_PHONE => "7563126",



	// -- Datos de la tarjeta de crédito --

        // Ingresa aquí el número de la tarjeta de crédito

	PayUParameters::CREDIT_CARD_NUMBER => "4037997623271984",

	// Ingresa aquí la fecha de expiración de la tarjeta de crédito

	PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2030/12",

	// Ingresa aquí el código de seguridad de la tarjeta de crédito

	PayUParameters::CREDIT_CARD_SECURITY_CODE=> "321",

	// Ingresa aquí el nombre de la tarjeta de crédito

	PayUParameters::PAYMENT_METHOD => "VISA",



	// Ingresa aquí el número de cuotas.

	PayUParameters::INSTALLMENTS_NUMBER => "1",

	// Ingresa aquí el nombre del país.

	PayUParameters::COUNTRY => PayUCountries::CO,



	// Device Session ID

	PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",

	// IP del pagador

	PayUParameters::IP_ADDRESS => "127.0.0.1",

	// Cookie de la sesión actual

	PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",

	// User agent de la sesión actual

	PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"

	);



// Petición de Autorización

$response = PayUPayments::doAuthorizationAndCapture($parameters);



// Puedes obtener las propiedades en la respuesta

if ($response) {

	$response->transactionResponse->orderId;

	$response->transactionResponse->transactionId;

	$response->transactionResponse->state;

	if ($response->transactionResponse->state=="PENDING"){

		$response->transactionResponse->pendingReason;

	}

	$response->transactionResponse->paymentNetworkResponseCode;

	$response->transactionResponse->paymentNetworkResponseErrorMessage;

	$response->transactionResponse->trazabilityCode;

	$response->transactionResponse->responseCode;

	$response->transactionResponse->responseMessage;



}
