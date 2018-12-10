<?php

namespace PHPassword\Crypt;

use PHPassword\Locator\Factory\FactoryInterface;
use PHPassword\Locator\SetLocatorImplementation;

class CryptFactory implements FactoryInterface
{
    use SetLocatorImplementation;

    /**
     * @return CryptInterface
     */
    public function createCryptingObject()
    {
        $cryptClass = $this->locator->parameter()->get('crypt_class', Aes256CbcCrypt::class);
        return new $cryptClass();
    }
}