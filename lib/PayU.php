<?php

require_once dirname(__FILE__).'/PayU/api/SupportedLanguages.php';
require_once dirname(__FILE__).'/PayU/api/PayUKeyMapName.php';
require_once dirname(__FILE__).'/PayU/api/PayUCommands.php';
require_once dirname(__FILE__).'/PayU/api/PayUTransactionResponseCode.php';
require_once dirname(__FILE__).'/PayU/api/PayUHttpRequestInfo.php';
require_once dirname(__FILE__).'/PayU/api/PayUResponseCode.php';
require_once dirname(__FILE__).'/PayU/api/PayuPaymentMethodType.php';
require_once dirname(__FILE__).'/PayU/api/PaymentMethods.php';
require_once dirname(__FILE__).'/PayU/api/PayUCountries.php';
require_once dirname(__FILE__).'/PayU/exceptions/PayUErrorCodes.php';
require_once dirname(__FILE__).'/PayU/exceptions/PayUException.php';
require_once dirname(__FILE__).'/PayU/exceptions/ConnectionException.php';
require_once dirname(__FILE__).'/PayU/api/PayUConfig.php';
require_once dirname(__FILE__).'/PayU/api/RequestMethod.php';
require_once dirname(__FILE__).'/PayU/util/SignatureUtil.php';
require_once dirname(__FILE__).'/PayU/api/PaymentMethods.php';
require_once dirname(__FILE__).'/PayU/api/TransactionType.php';
require_once dirname(__FILE__).'/PayU/util/PayURequestObjectUtil.php';
require_once dirname(__FILE__).'/PayU/util/PayUParameters.php';
require_once dirname(__FILE__).'/PayU/util/CommonRequestUtil.php';
require_once dirname(__FILE__).'/PayU/util/RequestPaymentsUtil.php';
require_once dirname(__FILE__).'/PayU/util/UrlResolver.php';
require_once dirname(__FILE__).'/PayU/util/PayUReportsRequestUtil.php';
require_once dirname(__FILE__).'/PayU/util/PayUTokensRequestUtil.php';
require_once dirname(__FILE__).'/PayU/util/PayUSubscriptionsRequestUtil.php';
require_once dirname(__FILE__).'/PayU/util/PayUSubscriptionsUrlResolver.php';
require_once dirname(__FILE__).'/PayU/util/HttpClientUtil.php';
require_once dirname(__FILE__).'/PayU/util/PayUApiServiceUtil.php';
require_once dirname(__FILE__).'/PayU/api/Environment.php';
require_once dirname(__FILE__).'/PayU/PayUBankAccounts.php';
require_once dirname(__FILE__).'/PayU/PayUPayments.php';
require_once dirname(__FILE__).'/PayU/PayUReports.php';
require_once dirname(__FILE__).'/PayU/PayUTokens.php';
require_once dirname(__FILE__).'/PayU/PayUSubscriptions.php';
require_once dirname(__FILE__).'/PayU/PayUCustomers.php';
require_once dirname(__FILE__).'/PayU/PayUSubscriptionPlans.php';
require_once dirname(__FILE__).'/PayU/PayUCreditCards.php';
require_once dirname(__FILE__).'/PayU/PayURecurringBill.php';
require_once dirname(__FILE__).'/PayU/PayURecurringBillItem.php';

/**
 * Holds basic request information
 * 
 * @version 1.0.0, 20/10/2013
 */
abstract class PayU {
	
	/**
	 * Api version
	 */
	const  API_VERSION = "4.0.1";

	/**
	 * Api name
	 */
	const  API_NAME = "PayU SDK";
	
	/**
	 * The method invocation is for testing purposes
	 */
	public static $isTest = false;

	/**
	 * The merchant API key
	 */
	public static  $apiKey;

	/**
	 * The merchant API Login
	 */
	public static  $apiLogin;

	/**
	 * The merchant Id
	 */
	public static  $merchantId;

	/**
	 * The request language
	 */
	public static $language = SupportedLanguages::ES;
}

// Set credentials

PayU::$apiKey = "tsG2CYzQLRDpQhkj6wmj6h5siZ"; // API Key de producción
PayU::$apiLogin = "5poAbwFB9ewb47Y"; // API Login de producción
PayU::$merchantId = "1008897"; // Merchant ID de producción

// Validate environment before beginning any operation
Environment::validate();

?>
