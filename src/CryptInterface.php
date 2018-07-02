<?php

namespace PHPassword\Crypt;

interface CryptInterface
{
    /**
     * @param string $secret
     * @param string $message
     * @return string
     */
    public function encrypt(string $secret, string $message): string;

    /**
     * @param string $secret
     * @param string $encryptedMessage
     * @return string
     */
    public function decrypt(string $secret, string $encryptedMessage): string;
}