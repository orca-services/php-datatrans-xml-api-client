<?php

namespace OrcaServices\Datatrans\Xml\Api\Request;

/**
 * Datatrans XML API Cancel Request
 *
 * The Cancel Request is often also referred to as “Reversal”. It can be used in order to cancel
 * authorizations of credit card, PayPal or PostFinance transactions. The Cancel Request releases
 * the blocked amount on credit card, PayPal or Postfinance accounts.
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
class Cancel extends SettlementBase
{

    /**
     * Set the elements for the Request XML
     *
     * @param \SimpleXMLElement $requestChild The request XML element to set the elements into.
     * @return void
     */
    protected function _setRequestXmlElements($requestChild)
    {
        $requestChild->addChild('uppTransactionId', $this->_uppTransactionId);
        $requestChild->addChild('amount', $this->_amount);
        $requestChild->addChild('currency', $this->_currency);
        $requestType = 'DOA';
        $requestChild->addChild('reqtype', $requestType);
    }
}
