<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

/**
 * Datatrans XML API Settlement Request
 *
 * The Settlement Request is often also referred to as “Capture” or “Clearing”. It can be used for the settlement of previously authorized transactions.
 *
 * Please note:
 *
 * - The authorized amount must not be exceeded.
 * - The key reference parameter is “uppTransactionId”; in the past, this used to be “authorizationCode”;
 * this is still supported, but no longer recommended.
 * - Authorized transactions can only be settled once; partial settlement requests (i.e. 1 x authorization of
 * EUR 100 / 2 x settlement of EUR 50) are not supported.
 * - Some payment methods such as Sofort.com or iDEAL do not support deferred settlement.
 *
 * This class does NOT support sending requests using the authorizationCode.
 *
 * @see https://www.datatrans.ch/showcase/settlement/xml-settlement-request
 */
class Settlement extends Base
{

    /**
     * The XML API Endpoint URL
     *
     * @var string
     */
    protected $_apiUrl = 'XML_processor.jsp';

    /**
     * The XML schema to validate the request & response against
     *
     * @var string
     */
    protected $_xmlSchema = 'payment.xsd';

    protected function _buildRequestXml()
    {
        // TODO: Implement _buildRequestXml() method.
    }

    protected function _processResponse($responseXml)
    {
        // TODO: Implement _processResponse() method.
    }
}
