<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

use \Exception;
use GuzzleHttp\Client;

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

        $requestChild = $transactionChild->addChild('request');

        $requestChild->addChild('uppTransactionId', $this->_uppTransactionId);
        $requestChild->addChild('amount', $this->_amount);
        $requestChild->addChild('currency', $this->_currency);

        $xml = $xml->asXML();

        return $xml;
    }

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
