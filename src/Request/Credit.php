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
class Credit extends SettlementBase
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
        $transType = '06';
        $requestChild->addChild('transtype', $transType);
    }
}
