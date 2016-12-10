<?php

// Load Composer Autoloader
require '../vendor/autoload.php';

// Import API client factory class
use OrcaServices\Datatrans\Xml\Api\Factory;

// Set required request data
$merchantId = '1000011011';
$uppTransactionId = '800247117123456789';
$refNo = '17656';
$currency = 'CHF'; // not considered for cancellation, but mandatory field
$amount = 100; // 1.00, not considered for cancellation, but mandatory field

// ATTENTION: Use the production environment
// Factory::setUseProdEnv(true);

// Create a Cancel Request object through the factory
$cancelRequest = Factory::cancel($merchantId, $uppTransactionId, $refNo, $currency, $amount);

// Disable request and response validation
//$cancelRequest->setValidate(false);

// Execute the request
$cancelRequest->execute();

$error = $cancelRequest->getError();
var_dump($error);
$response = $cancelRequest->getResponse();
var_dump($response);
