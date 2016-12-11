<?php

namespace OrcaServices\Datatrans\Xml\Api;

use \InvalidArgumentException;

/**
 * Datatrans Payment XML API Digital Signature
 *
 * Provides functions to set the digital sign security level & signature.
 */
trait DigitalSignature
{
    /**
     * The digital signature security level, allows 0, 1, or 2, defaults to 0 (= none)
     *
     * @var int
     */
    protected static $_signSecurityLevel = 0;

    /**
     * The optional digital signature to use
     *
     * @var null|string
     */
    protected static $_signature;

    /**
     * Set the digital signature security level
     *
     * @param int $signSecurityLevel The digital signature security level, allows 0, 1, or 2.
     * @return void
     * @throws \InvalidArgumentException If not a valid security level given.
     */
    public static function setSignSecurityLevel($signSecurityLevel)
    {
        if (!in_array($signSecurityLevel, array(0, 1, 2), true)) {
            throw new InvalidArgumentException('Given $signSecurityLevel is not a valid security level (0, 1, 2).');
        }
        self::$_signSecurityLevel = $signSecurityLevel;
    }

    /**
     * Set the digital signature to use
     *
     * @param string $signature he digital signature to use.
     * @return void
     * @throws \InvalidArgumentException When not a string given.
     */
    public static function setSignature($signature)
    {
        if (!is_string($signature)) {
            throw new InvalidArgumentException('Given $signature is not a string.');
        }
        self::$_signature = $signature;
    }

}