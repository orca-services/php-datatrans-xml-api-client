<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

/**
 * Datatrans XML API Cancel Request
 *
 * The Cancel Request is often also referred to as “Reversal”. It can be used in order to cancel authorizations of credit card, PayPal or PostFinance transactions. The Cancel Request releases the blocked amount on credit card, PayPal or Postfinance accounts.
 *
 * Please note:
 *
 * - The key reference parameter is “uppTransactionId”; in the past, this used to be “authorizationCode”;
 * this is still supported, but no longer recommended.
 * - Authorized transactions cannot be cancelled partially; the Cancel Request reverses the transaction completely.
 * - Not all credit card issuers support Cancel Requests.
 *
 * This class does NOT support sending requests using the authorizationCode.
 *
 * @see https://www.datatrans.ch/showcase/settlement/xml-cancel-request
 */
class Cancel extends Base
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
