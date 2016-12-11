<?php

/**
 * This example shows how to setup and send a Status Request to the Datatrans Payment XML API
 */

// Load Composer Autoloader
require '../vendor/autoload.php';

// Import API client factory class
// Import CA bundle for certificate verification
use OrcaServices\Datatrans\Xml\Api\Factory;
use Composer\CaBundle\CaBundle;

// Set required request data
$merchantId = '1000011011';
$transactionId = '407767998123456789';

// Optionally, setup the request options for the HTTP client
$requestOptions = array(
    'verify' => CaBundle::getBundledCaBundlePath(),
    //'auth' => array('username', 'password'),
);

// Optionally, setup a Guzzle HTTP client object through the factory, using the request options
$httpClient = Factory::httpClient($requestOptions);

// ATTENTION: Use the production environment
//Factory::setUseProdEnv(true);

// Create a Status Request object through the factory
$statusRequest = Factory::status($merchantId, $transactionId);

// Disable request and response validation
//$statusRequest->setValidate(false);

// Execute the request
$statusRequest->execute();

$error = $statusRequest->getError();
var_dump($error);
$response = $statusRequest->getResponse();
var_dump($response);
