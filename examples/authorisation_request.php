<?php

use OrcaServices\Datatrans\Xml\Api\Factory;

$merchantId = 1000011011;
$transactionRefNo = 522061;

$authorisationRequest = Factory::authorisation($merchantId, $transactionRefNo);
$authorisationRequest->execute();
