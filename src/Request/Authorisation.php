<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

/**
 * Datatrans XML API Authorisation Request
 *
 * The XML Authorisation service is available as plain XML interface or as SOAP API.
 *
 * It’s applicable to the following transaction cases:
 *
 * - One-click check-out for registered customers
 * - Recurring billing
 * - Alias verification (amount=0)
 *
 * Supported payment methods:
 *
 * - Credit cards
 * - PayPal Reference Transactions
 * - PostFinance Alias
 * - German ELV (“Lastschriftverfahren”)
 * - Loyalty cards (Manor MyOne, Jelmoli Bonus etc.)
 *
 * Important notes:
 *
 * - Due to the PCI regulations, the XML Authorisation API must not be used with plain credit card numbers.
 * - The XML Authorisation API does only support payment methods which can be processed with aliases instead
 * of real card- or account numbers.
 * - 3-D Secure is not supported by the XML Authorisation API
 *
 * Documentation:
 * not yet available; please refer to the Datatrans support Team.
 *
 * @see https://www.datatrans.ch/showcase/authorisation/xml-authorisation
 */
class Authorisation extends Base
{

    /**
     * The XML API Endpoint URL
     *
     * @var string
     */
    protected $_apiUrl = 'XML_authorize.jsp';

    /**
     * The XML schema to validate the request & response against
     *
     * @var string
     */
    protected $_xmlSchema = 'authorization.xsd';

    protected function _buildRequestXml()
    {
        // TODO: Implement _buildRequestXml() method.
    }

    protected function _processResponse($responseXml)
    {
        // TODO: Implement _processResponse() method.
    }
}
