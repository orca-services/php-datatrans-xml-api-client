<?php

// Load Composer Autoloader
require '../vendor/autoload.php';

// Import API client factory class
use OrcaServices\Datatrans\Xml\Api\Factory;

// Set required request data
$merchantId = '1000011011';
$uppTransactionId = '800247117123456789';
$refNo = '841689';
$currency = 'CHF';
$amount = 100; // 1.00

// ATTENTION: Use the production environment
// Factory::setUseProdEnv(true);

// Create a Settlement Request object through the factory
$settlementRequest = Factory::settlement($merchantId, $uppTransactionId, $refNo, $currency, $amount);

// Disable request and response validation
$settlementRequest->setValidate(false);

// Execute the request
$settlementRequest->execute();

$error = $settlementRequest->getError();
var_dump($error);
$response = $settlementRequest->getResponse();
var_dump($response);
