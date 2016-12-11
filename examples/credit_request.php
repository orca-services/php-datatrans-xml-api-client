<?php

/**
 * This example show how to setup and send a Credit Request to the Datatrans Payment XML API
 */

// Load Composer Autoloader
require '../vendor/autoload.php';

// Import API client factory class
// Import CA bundle for certificate verification
use OrcaServices\Datatrans\Xml\Api\Factory;
use Composer\CaBundle\CaBundle;

// Set required request data
$merchantId = '1000011011';
$uppTransactionId = '800247117123456789';
$refNo = '589681';
$currency = 'CHF';
$amount = 100; // 1.00

// Optionally, setup the request options for the HTTP client
$requestOptions = array(
    'verify' => CaBundle::getBundledCaBundlePath(),
    //'auth' => array('username', 'password'),
);

// Optionally, setup a Guzzle HTTP client object through the factory, using the request options
$httpClient = Factory::httpClient($requestOptions);

// ATTENTION: Use the production environment
// Factory::setUseProdEnv(true);

// Create a Credit Request object through the factory
$creditRequest = Factory::credit($merchantId, $uppTransactionId, $refNo, $currency, $amount);

// Disable request and response validation
//$creditRequest->setValidate(false);

// Execute the request
$creditRequest->execute();

$error = $creditRequest->getError();
var_dump($error);
$response = $creditRequest->getResponse();
var_dump($response);
