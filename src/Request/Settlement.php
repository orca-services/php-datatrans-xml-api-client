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
class Settlement extends SettlementBase
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
    }
}
