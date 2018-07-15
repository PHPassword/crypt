<?php

namespace PHPassword\Crypt;


class Aes256CbcCrypt implements CryptInterface
{
    /**
     * @var string
     */
    private static $encryptionMethod = 'aes-256-cbc';

    /**
     * @param string $secret
     * @param string $message
     * @return string
     */
    public function encrypt(string $secret, string $message) : string
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$encryptionMethod));
        $encryptedMessage = openssl_encrypt($message, self::$encryptionMethod, $secret, 0, $iv);

        if($encryptedMessage === false){
            throw new \RuntimeException('Encryption failed');
        }

        return $encryptedMessage . ':' . base64_encode($iv);
    }

    /**
     * @param string $secret
     * @param string $encryptedMessage
     * @return string
     */
    public function decrypt(string $secret, string $encryptedMessage) : string
    {
        $encryptedMessageParts = explode(':', $encryptedMessage);
        $iv = base64_decode($encryptedMessageParts[1]);
        $encryptedMessage = $encryptedMessageParts[0];

        $message = openssl_decrypt($encryptedMessage, self::$encryptionMethod, $secret, 0, $iv);

        if($message === false){
            throw new \RuntimeException('Decryption failed');
        }

        return $message;
    }
}