<?php

declare(strict_types=1);

namespace OrderService\ValueObjects;

use OrderService\ValueObjects\Exception\AddressCityIsEmpty;
use OrderService\ValueObjects\Exception\AddressCountryIsEmpty;
use OrderService\ValueObjects\Exception\AddressRingNameIsEmpty;
use OrderService\ValueObjects\Exception\AddressStateIsEmpty;
use OrderService\ValueObjects\Exception\AddressStreetIsEmpty;
use OrderService\ValueObjects\Exception\AddressZipCodeIsEmpty;

final class Address
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $ringName;

    public function __construct(
        string $street,
        string $city,
        string $state,
        string $country,
        string $zipCode,
        string $ringName
    ) {
        if ('' === $street) {
            throw new AddressStreetIsEmpty();
        }
        if ('' === $city) {
            throw new AddressCityIsEmpty();
        }
        if ('' === $state) {
            throw new AddressStateIsEmpty();
        }
        if ('' === $country) {
            throw new AddressCountryIsEmpty();
        }
        if ('' === $zipCode) {
            throw new AddressZipCodeIsEmpty();
        }
        if ('' === $ringName) {
            throw new AddressRingNameIsEmpty();
        }
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zipCode = $zipCode;
        $this->ringName = $ringName;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function state(): string
    {
        return $this->state;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function zipCode(): string
    {
        return $this->zipCode;
    }

    public function ringName(): string
    {
        return $this->ringName;
    }

    public function __toString(): string
    {
        return "{$this->ringName}, {$this->street} {$this->city} {$this->zipCode}, {$this->state} {$this->country}";
    }

    public function isEquals(self $address): bool
    {
        return
            $this->street === $address->street &&
            $this->city === $address->city &&
            $this->state === $address->state &&
            $this->country === $address->country &&
            $this->zipCode === $address->zipCode &&
            $this->ringName === $address->ringName;
    }

    private function __clone()
    {
    }
}
