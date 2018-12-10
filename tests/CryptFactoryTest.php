<?php

use PHPassword\Crypt\Aes256CbcCrypt;
use PHPassword\Crypt\CryptFactory;
use PHPassword\Crypt\CryptInterface;
use PHPassword\Locator\Locator;
use PHPassword\Locator\LocatorParameter;
use PHPassword\Locator\Proxy\LocatorProxyFactory;
use PHPUnit\Framework\TestCase;

class CryptFactoryTest extends TestCase
{
    /**
     * @var Locator
     */
    private static $locator;

    public static function setUpBeforeClass()
    {
        $factory = new LocatorProxyFactory(new ArrayObject(['PHPassword\\']));
        static::$locator = new Locator($factory);
    }

    /**
     * @throws Exception
     */
    public function testCreateCryptingObject()
    {
        $factory = new CryptFactory();
        $factory->setLocator(static::$locator);
        $this->assertInstanceOf(CryptInterface::class, $factory->createCryptingObject());
    }

    /**
     * @throws Exception
     */
    public function testCreateCryptingObjectWithClassPrameter()
    {
        $factory = new LocatorProxyFactory(new ArrayObject(['PHPassword\\']));
        $locator = new Locator($factory, new LocatorParameter(['crypt_class' => Aes256CbcCrypt::class]));

        $factory = new CryptFactory();
        $factory->setLocator($locator);
        $this->assertInstanceOf(Aes256CbcCrypt::class, $factory->createCryptingObject());
    }
}