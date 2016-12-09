<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

/**
 * Datatrans XML API Credit Request
 *
 * The Credit Request can be used for refunds of previously authorised and settled transactions.
 *
 * Please note:
 *
 * - The previously settled amount must not be exceeded.
 * - The key reference parameter is “uppTransactionId”; in the past, this used to be “authorizationCode”;
 * this is still supported, but no longer recommended.
 * - Transactions can also be partially refunded; partial refund requests (i.e. 1 x settled transaction
 * of EUR 100 / 2 x credit of EUR 50) are supported for most payment methods; please refer to the Datatrans
 * support team for information about restrictions with certain payment methods.
 * - Some payment methods such as Sofort.com, German ELV or iDEAL do not support credit requests.
 *
 * This class does NOT support sending requests using the authorizationCode.
 *
 * @see https://www.datatrans.ch/showcase/settlement/xml-credit-request
 */
class Credit extends Base
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
