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
            throw new InvalidArgumentException('Not a boolean');
        }
        static::$_useProdEnv = $useProdEnv;
    }

    /**
     * Create a Authorisation Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $transactionRefNo The transaction reference number, e.g. 274815.
     * @return Authorisation A Authorisation request object ready to execute.
     */
    public static function authorisation($merchantId, $transactionRefNo)
    {
        $guzzle = static::_getHttpClient();
        $request = new Authorisation($guzzle, $merchantId, $transactionRefNo);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Create a Cancel Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $transactionRefNo The transaction reference number, e.g. 274815.
     * @return Cancel A Cancel request object ready to execute.
     */
    public static function cancel($merchantId, $transactionRefNo)
    {
        $guzzle = static::_getHttpClient();
        $request = new Cancel($guzzle, $merchantId, $transactionRefNo);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Create a Credit Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $transactionRefNo The transaction reference number, e.g. 274815.
     * @return Credit A Credit request object ready to execute.
     */
    public static function credit($merchantId, $transactionRefNo)
    {
        $guzzle = static::_getHttpClient();
        $request = new Credit($guzzle, $merchantId, $transactionRefNo);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Create a Settlement Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $transactionRefNo The transaction reference number, e.g. 274815.
     * @return Settlement A Settlement request object ready to execute.
     */
    public static function settlement($merchantId, $transactionRefNo)
    {
        $guzzle = static::_getHttpClient();
        $request = new Settlement($guzzle, $merchantId, $transactionRefNo);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Create a Status Request
     *
     * @param string $merchantId The merchant ID.
     * @param string $transactionRefNo The transaction reference number, e.g. 274815.
     * @return Status A Status request object ready to execute.
     */
    public static function status($merchantId, $transactionRefNo)
    {
        $guzzle = static::_getHttpClient();
        $request = new Status($guzzle, $merchantId, $transactionRefNo);
        $request->setUseProdEnv(static::$_useProdEnv);

        return $request;
    }

    /**
     * Get HTTP client
     *
     * @return Client
     */
    protected function _getHttpClient()
    {
        if (!static::$_client) {
            static::$_client = new Client();
        }
        return static::$_client;
    }
}
