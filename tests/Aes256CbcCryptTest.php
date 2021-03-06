<?php

use PHPassword\Crypt\Aes256CbcCrypt;
use PHPUnit\Framework\TestCase;

class Aes256CbcCryptTest extends TestCase
{
    public function testEncrypt()
    {
        $testString = 'My string to test';
        $testPassword = 'test';
        $crypt = new Aes256CbcCrypt();
        $encrypted = $crypt->encrypt($testPassword, $testString);

        $this->assertSame($testString, $crypt->decrypt($testPassword, $encrypted));
    }

    public function testDecryptFail()
    {
        $crypt = new Aes256CbcCrypt();
        $encrypted = $crypt->encrypt('test', 'My string to test');
        $this->expectException(RuntimeException::class);
        $crypt->decrypt('wrongPassword', $encrypted);
    }
}