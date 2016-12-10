<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

use \DOMDocument;
use \Exception;
use GuzzleHttp\Client;
use \InvalidArgumentException;
use \SimpleXMLElement;

/**
 * Base implementation for Datatrans XML API Requests
 */
abstract class Base
{

    /**
     * Whether to use the Production or Test environment
     *
     * @var bool
     */
    protected $_useProdEnv = false;

    /**
     * The XML API Endpoint Base URL
     *
     * @var string
     */
    protected $_apiBaseProdUrl = 'https://payment.datatrans.biz/upp/jsp/';

    /**
     * The XML API Endpoint Base URL
     *
     * @var string
     */
    protected $_apiBaseTestUrl = 'https://pilot.datatrans.biz/upp/jsp/';

    /**
     * The XML API Endpoint URL
     *
     * @var string
     */
    protected $_apiUrl = 'XML_authorize.jsp';

    /**
     * The guzzle HTTP client object
     *
     * @var Client
     */
    protected $_client;

    /**
     * The XML schema to validate the response against
     *
     * @var string
     */
    protected $_xmlSchema = '';

    /**
     * Whether to validate the request and response
     *
     * @var bool
     */
    protected $_validate = true;

    /**
     * The merchant ID
     *
     * @var int
     */
    protected $_merchantId;

    /**
     * The unique transaction id
     *
     * @var int
     */
    protected $_uppTransactionId;

    /**
     * The response data, if the request succeeded
     *
     * @var
     */
    protected $_response;

    /**
     * The error data, if the request failed
     *
     * @var
     */
    protected $_error;

    /**
     * Construct a request
     *
     * @param Client $httpClient The HTTP client to use.
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     */
    public function __construct($httpClient, $merchantId, $uppTransactionId)
    {
        $this->setMerchantId($merchantId);
        $this->setUppTransactionId($uppTransactionId);
        $this->_client = $httpClient;
    }

    /**
     * Set whether to use the production or test environment
     *
     * @param boolean $useProdEnv Whether to use the production or test environment.
     * @return self
     */
    public function setUseProdEnv($useProdEnv)
    {
        if (!is_bool($useProdEnv)) {
            throw new InvalidArgumentException('Not a boolean');
        }
        $this->_useProdEnv = $useProdEnv;

        return $this;
    }

    /**
     * Set whether to validate the requests and responses
     *
     * @param bool $validate Whether to validate the requests and reponses.
     * @return self
     */
    public function setValidate($validate)
    {
        $this->_validate = $validate;

        return $this;
    }

    /**
     * Set the merchant ID
     *
     * @param string $merchantId The merchant ID, e.g. 1000011011.
     * @return self
     */
    public function setMerchantId($merchantId)
    {
        $this->_merchantId = $merchantId;

        return $this;
    }

    /**
     * Set the unique transaction id
     *
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @return self
     */
    public function setUppTransactionId($uppTransactionId)
    {
        $this->_uppTransactionId = $uppTransactionId;

        return $this;
    }

    /**
     * Execute the request
     *
     * @return self
     * @throws Exception If something is wrong with the request or response XML.
     */
    public function execute()
    {
        $apiUrl = $this->_buildApiUrl();

        $xmlSchema = $this->_getXmlSchema();
        $requestXML = $this->_buildRequestXml();
        if (!$this->_validateXml($requestXML, $xmlSchema)) {
            throw new Exception('Invalid request XML generated.');
        }

        $response = $this->_client->post($apiUrl, array(
            'body' => $requestXML,
        ));

        $responseXml = $response->getBody()->getContents();
        if (!$this->_validateXml($responseXml, $xmlSchema)) {
            throw new Exception('Invalid XML response received from Datatrans.');
        }

        $responseXml = simplexml_load_string($responseXml);
        $this->_processResponse($responseXml);

        return $this;
    }

    /**
     * Get the XML for the request
     *
     * @return string The XML for the request.
     */
    abstract protected function _buildRequestXml();

    /**
     * Process the response
     *
     * @param SimpleXMLElement $responseXml The response XML to process.
     * @return void
     */
    abstract protected function _processResponse($responseXml);

    /**
     * Get the full path to the XML schema file
     *
     * @return string The full path to the XML schema file.
     * @throws  Exception When not XMl schema was found.
     */
    protected function _getXmlSchema()
    {
        $xmlSchema =  dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR .
            'resources' . DIRECTORY_SEPARATOR  .
            'xsd' . DIRECTORY_SEPARATOR .
            $this->_xmlSchema;

        if (!file_exists($xmlSchema)) {
            throw new Exception('XML schema not found at ' . $xmlSchema);
        }

        return $xmlSchema;
    }

    /**
     * Build the API Endpoint URL depending on which environment to use
     *
     * @return string The API Endpoint URl depending on which environment to use.
     */
    protected function _buildApiUrl()
    {
        if ($this->_useProdEnv === true) {
            return $this->_apiBaseProdUrl . $this->_apiUrl;
        }
        return $this->_apiBaseTestUrl . $this->_apiUrl;
    }

    /**
     * Validate XML against a given XML schema file
     *
     * Suppresses the PHP warnings normally emitted by libxml.
     *
     * @param string $xml The XML data to validate.
     * @param string $xmlSchema The XML schema file to validate against.
     * @return bool True if valid, else false.
     */
    protected function _validateXml($xml, $xmlSchema)
    {
        if (!$this->_validate) {
            return true;
        }
        libxml_use_internal_errors(true);
        $xmlDoc = new DOMDocument();
        if (!$xmlDoc->loadXML($xml, LIBXML_NOERROR)) {
            return false;
        }
        if (!$xmlDoc->schemaValidate($xmlSchema)) {
            return false;
        }

        return true;
    }

    /**
     * Get the response data
     *
     * Returns null, if the request failed.
     *
     * @return null|SimpleXMLElement The response data, if the request succeeded.
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Get the error data
     *
     * Returns null, if the request succeeded.
     *
     * @return null|SimpleXMLElement The error data, if the request failed.
     */
    public function getError()
    {
        return $this->_error;
    }
}
