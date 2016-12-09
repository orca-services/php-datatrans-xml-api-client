<?php

// Load Composer Autoloader
require '../vendor/autoload.php';

// Import API client factory class
use OrcaServices\Datatrans\Xml\Api\Factory;

// Set required request data
$merchantId = '1000011011';
$transactionRefNo = '407767998123456789';

// ATTENTION: Use the production environment
// Factory::setUseProdEnv(true);

// Create a Status Request object through the factory
$statusRequest = Factory::status($merchantId, $transactionRefNo);

// Disable request and response validation
$statusRequest->setValidate(false);

// Execute the request
$statusRequest->execute();

$error = $statusRequest->getError();
var_dump($error);
$response = $statusRequest->getResponse();
var_dump($response);


