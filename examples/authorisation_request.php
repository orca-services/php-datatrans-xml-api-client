<?php

use OrcaServices\Datatrans\Xml\Api\Factory;

$merchantId = 1000011011;
$uppTransactionId = 522061;

$authorisationRequest = Factory::authorisation($merchantId, $uppTransactionId);
$authorisationRequest->execute();
