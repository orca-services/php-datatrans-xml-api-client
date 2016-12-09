<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

use \Exception;

/**
 * Datatrans XML API Status Request
 *
 * The Status Request returns the actual status of a transaction in the Datatrans transaction database.
 *
 * The key reference parameter can be one of the following:
 *
 * - refno (merchant reference number)
 * - uppTransactionId
 * - authorizationCode (outdated, not recommended)
 *
 * @see https://www.datatrans.ch/showcase/status-request/xml-status-request
 */
class Status extends Base
{

    /**
     * The XML API Endpoint URL
     *
     * @var string
     */
    protected $_apiUrl = 'XML_status.jsp';

    /**
     * The XML schema to validate the request & response against
     *
     * @var string
     */
    protected $_xmlSchema = 'status.xsd';

    /**
     * Build the XML for the request
     *
     * @return string The XML for the request.
     */
    protected function _buildRequestXml()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><statusService/>');
        $apiVersion = '3';
        $xml->addAttribute('version', $apiVersion);

        $bodyChild = $xml->addChild('body');
        $bodyChild->addAttribute('merchantId', $this->_merchantId);
        $requestChild = $bodyChild ->addChild('transaction')->addChild('request');

        $requestChild->addChild('uppTransactionId', $this->_transactionRefNo);
        $requestType = 'STX'; // Extended status
        $requestChild->addChild('reqtype', $requestType);

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
        // Request succeeded
        if (isset($responseXml->body->transaction->response)) {
            $this->_response = $responseXml->body->transaction->response;
            return;
        }

        throw new Exception('No data to process found');
    }
}
