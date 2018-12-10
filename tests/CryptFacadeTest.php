<?php

use PHPassword\Crypt\Aes256CbcCrypt;
use PHPassword\Crypt\CryptFacade;
use PHPassword\Crypt\CryptFactory;
use PHPassword\Crypt\CryptInterface;
use PHPassword\Locator\Locator;
use PHPassword\Locator\LocatorParameter;
use PHPassword\Locator\Proxy\LocatorProxyFactory;
use PHPUnit\Framework\TestCase;

class CryptFacadeTest extends TestCase
{
    /**
     * @var Locator
     */
    private static $locator;

    public static function setUpBeforeClass()
    {
        $factory = new LocatorProxyFactory(new ArrayObject(['PHPassword\\']));
        static::$locator = new Locator($factory, new LocatorParameter([
            'crypt_class' => Aes256CbcCrypt::class,
            'crypt_secret' => 'myOwnSecret!@@@'
        ]));
    }

    /**
     * @throws Exception
     */
    public function testEncrypt()
    {
        $facade = new CryptFacade();
        $facade->setLocator(static::$locator);
        $customSecret = 'myVeryOwnSecret#123@';
        $testString = 'mysecretstring';

        $this->assertStringEndsWith('==', $facade->encrypt($testString));
        $this->assertStringEndsWith('==', $facade->encrypt($testString, $customSecret));
    }

    /**
     * @throws Exception
     */
    public function testDecrypt()
    {
        $facade = new CryptFacade();
        $facade->setLocator(static::$locator);
        $testString = 'mysecretstring';

        $encryptedTestString = $facade->encrypt($testString);
        $this->assertSame($testString, $facade->decrypt($encryptedTestString));

        $customSecret = 'myVeryOwnSecret#123@';
        $encryptedTestString = $facade->encrypt($testString, $customSecret);
        $this->assertSame($testString, $facade->decrypt($encryptedTestString, $customSecret));

        $customSecret = 'myVeryWrongSecret#123@';
        $this->expectException(\RuntimeException::class);
        $this->assertSame($testString, $facade->decrypt($encryptedTestString, $customSecret));
    }
}