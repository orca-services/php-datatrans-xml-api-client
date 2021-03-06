<?php

namespace OrcaServices\Datatrans\Xml\Api;

use GuzzleHttp\Client;
use OrcaServices\Datatrans\Xml\Api\Request\Authorisation;
use OrcaServices\Datatrans\Xml\Api\Request\Cancel;
use OrcaServices\Datatrans\Xml\Api\Request\Credit;
use OrcaServices\Datatrans\Xml\Api\Request\Settlement;
use OrcaServices\Datatrans\Xml\Api\Request\Status;
use \InvalidArgumentException;

/**
 * A Factory to create Datatrans XML requests
 *
 * Can create the following request objects:
 *
 * - Authorisation
 * - Cancel
 * - Credit
 * - Settlement
 * - Status
 *
 * @see Authorisation
 * @see Cancel
 * @see Credit
 * @see Settlement
 * @see Status
 */
class Factory
{
    /**
     * Use the digital signature trait
     */
    use DigitalSignature;

    /**
     * The HTTP client
     *
     * @var Client
     */
    protected static $_client;

    /**
     * Whether to use the production or test environment, defaults to test.
     *
     * @var bool
     */
    protected static $_useProdEnv = false;

    /**
     * Set whether to use the production or test environment when creating request objects
     *
     * @param bool $useProdEnv Whether to use the production or test environment.
     * @return void
     * @throws \InvalidArgumentException When not a boolean given.
     */
    public static function setUseProdEnv($useProdEnv)
    {
        if (!is_bool($useProdEnv)) {
            throw new InvalidArgumentException('Given $useProdEnv is not a boolean.');
        }
        static::$_useProdEnv = $useProdEnv;
    }

    /**
     * Create a Authorisation Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @return Authorisation A Authorisation request object ready to execute.
     */
    public static function authorisation($merchantId, $uppTransactionId)
    {
        $httpClient = static::httpClient();
        $request = new Authorisation($httpClient, $merchantId, $uppTransactionId);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Create a Cancel Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @param string $refNo Merchant order reference number.
     * @param string $currency Transaction currency - ISO character code (e.g. CHF).
     * @param int $amount Transaction amount in cents (the smallest unit of the currency) (e.g. 123.50 = 12350).
     * @return Cancel A Cancel request object ready to execute.
     */
    public static function cancel($merchantId, $uppTransactionId, $refNo, $currency, $amount)
    {
        $httpClient = static::httpClient();
        $request = new Cancel($httpClient, $merchantId, $uppTransactionId, $refNo, $currency, $amount);
        $request->setUseProdEnv(static::$_useProdEnv);

        $request::setSignSecurityLevel(static::$_signSecurityLevel);
        $request::setSignature(static::$_signature);

        return $request;
    }

    /**
     * Create a Credit Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @param string $refNo Merchant order reference number.
     * @param string $currency Transaction currency - ISO character code (e.g. CHF).
     * @param int $amount Transaction amount in cents (the smallest unit of the currency) (e.g. 123.50 = 12350).
     * @return Credit A Credit request object ready to execute.
     */
    public static function credit($merchantId, $uppTransactionId, $refNo, $currency, $amount)
    {
        $httpClient = static::httpClient();
        $request = new Credit($httpClient, $merchantId, $uppTransactionId, $refNo, $currency, $amount);
        $request->setUseProdEnv(static::$_useProdEnv);

        $request::setSignSecurityLevel(static::$_signSecurityLevel);
        $request::setSignature(static::$_signature);

        return $request;
    }

    /**
     * Create a Settlement Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @param string $refNo Merchant order reference number.
     * @param string $currency Transaction currency - ISO character code (e.g. CHF).
     * @param int $amount Transaction amount in cents (the smallest unit of the currency) (e.g. 123.50 = 12350).
     * @return Settlement A Settlement request object ready to execute.
     */
    public static function settlement($merchantId, $uppTransactionId, $refNo, $currency, $amount)
    {
        $httpClient = static::httpClient();
        $request = new Settlement($httpClient, $merchantId, $uppTransactionId, $refNo, $currency, $amount);
        $request->setUseProdEnv(static::$_useProdEnv);

        $request::setSignSecurityLevel(static::$_signSecurityLevel);
        $request::setSignature(static::$_signature);

        return $request;
    }

    /**
     * Create a Status Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $uppTransactionId The unique transaction id, e.g. 274815.
     * @return Status A Status request object ready to execute.
     */
    public static function status($merchantId, $uppTransactionId)
    {
        $httpClient = static::httpClient();
        $request = new Status($httpClient, $merchantId, $uppTransactionId);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Get the HTTP client
     *
     * Overwrites the previous client when given new options.
     *
     * @param array $options The optional request options.
     * @return Client The HTTP client.
     */
    public static function httpClient($options = array())
    {
        if (!static::$_client || !empty($options)) {
            static::$_client = new Client($options);
        }
        return static::$_client;
    }
}
