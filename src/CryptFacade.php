<?php

namespace PHPassword\Crypt;


use PHPassword\Crypt\CryptInterface;
use PHPassword\Locator\Facade\FacadeInterface;
use PHPassword\Locator\SetLocatorImplementation;

class CryptFacade implements FacadeInterface
{
    use SetLocatorImplementation;

    /**
     * @var CryptInterface
     */
    private $crypt;

    /**
     * @param string $string
     * @param string|null $secret
     * @return string
     */
    public function encrypt(string $string, string $secret = null): string
    {
        $secret = $secret ?? $this->locator->parameter()->get('crypt_secret');
        return $this->getCrypt()->encrypt($secret, $string);
    }

    /**
     * @param string $string
     * @param string|null $secret
     * @return string
     */
    public function decrypt(string $string, string $secret = null): string
    {
        $secret = $secret ?? $this->locator->parameter()->get('crypt_secret');
        return $this->getCrypt()->decrypt($secret, $string);
    }

    /**
     * @return CryptInterface
     */
    private function getCrypt(): CryptInterface
    {
        if($this->crypt === null){
            $this->crypt = $this->locator->crypt()->factory()->createCryptingObject();
        }
        return $this->crypt;
    }
}