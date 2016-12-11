<?php

/**
 * This example show how to setup and send a Cancel Request to the Datatrans Payment XML API
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
$refNo = '17656';
$currency = 'CHF'; // not considered for cancellation, but mandatory field
$amount = 100; // 1.00, not considered for cancellation, but mandatory field

// Optionally, setup the request options for the HTTP client
$requestOptions = array(
    'verify' => CaBundle::getBundledCaBundlePath(),
    //'auth' => array('username', 'password'),
);

// Optionally, setup a Guzzle HTTP client object through the factory, using the request options
$httpClient = Factory::httpClient($requestOptions);

// ATTENTION: Use the production environment
//Factory::setUseProdEnv(true);

// Optionally set the digital sign security level and signature
//Factory::setSignSecurityLevel(1);
//Factory::setSignature('123');

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
