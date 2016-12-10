<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

use DoctrineTest\InstantiatorTestAsset\SimpleSerializableAsset;
use \Exception;
use GuzzleHttp\Client;

/**
 * Base class for all settlement-oriented requests
 *
 * The following requests share the same API endpoint and XML schema:
 *
 * - Settlement Request
 * - Credit Request
 * - Cancel Request
 *
 * @see https://www.datatrans.ch/showcase/settlement/xml-settlement-request
 */
abstract class SettlementBase extends Base
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

    /**
     * Merchant order reference number
     *
     * @var string
     */
    protected $_refNo;

    /**
     * Transaction currency - ISO character code (e.g. CHF)
     *
     * @var string
     */
    protected $_currency;

    /**
     * Transaction amount in cents (the smallest unit of the currency) (e.g. 123.50 = 12350)
     *
     * @var integer
     */
    protected $_amount;

    /**
     * Construct a settlement request
     *
     * @param Client $httpClient The HTTP client to use.
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @param string $refNo Merchant order reference number.
     * @param string $currency Transaction currency - ISO character code (e.g. CHF).
     * @param int $amount Transaction amount in cents (the smallest unit of the currency) (e.g. 123.50 = 12350).
     */
    public function __construct($httpClient, $merchantId, $uppTransactionId, $refNo, $currency, $amount)
    {
        parent::__construct($httpClient, $merchantId, $uppTransactionId);

        $this->setRefNo($refNo);
        $this->setCurrency($currency);
        $this->setAmount($amount);
    }

    /**
     * Set the transaction amount
     *
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Set the transaction currency
     *
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Set the merchant reference number
     *
     * @param string $refNo
     */
    public function setRefNo($refNo)
    {
        $this->_refNo = $refNo;
    }

    /**
     * Build the XML for the request
     *
     * @return string The XML for the request.
     */
    protected function _buildRequestXml()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><paymentService/>');
        $apiVersion = '1'; // TODO Make settable, with default value "1".
        $xml->addAttribute('version', $apiVersion);

        $bodyChild = $xml->addChild('body');
        $bodyChild->addAttribute('merchantId', $this->_merchantId);
        $transactionChild = $bodyChild->addChild('transaction');
        $transactionChild->addAttribute('refno', $this->_refNo);

        // TODO Implement errorEmail
        //$bodyChild->addChild('errorEmail', 'somebody@example.org');

        $requestChild = $transactionChild->addChild('request');

        $this->_setRequestXmlElements($requestChild);

        $xml = $xml->asXML();

        return $xml;
    }

    /**
     * Set the elements for the Request XML
     *
     * @param \SimpleXMLElement $requestChild The request XML element to set the elements into.
     * @return void
     */
    abstract protected function _setRequestXmlElements($requestChild);

    /**
     * Process the response
     *
     * {@inheritDocs}
     */
    protected function _processResponse($responseXml)
    {
        // Request was invalid
        if (isset($responseXml->error)) {
            $this->_error = $responseXml->error;
            return;
        }
        // Request body had errors
        if (isset($responseXml->body->error)) {
            $this->_error = $responseXml->body->error;
            return;
        }
        // Request transaction had errors
        if (isset($responseXml->body->transaction->error)) {
            $this->_error = $responseXml->body->transaction->error;
            return;
        }
        // Request succeeded
        if (isset($responseXml->body->transaction->response)) {
            $this->_response = $responseXml->body->transaction->response;
            return;
        }

        throw new Exception('No data to process found');
    }
}
