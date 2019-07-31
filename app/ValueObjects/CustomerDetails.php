<?php
declare(strict_types=1);

namespace OrderService\ValueObjects;

use OrderService\ValueObjects\Exception\CustomerFirstNameIsEmpty;

final class CustomerDetails
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var Address
     */
    private $billingAddress;

    /**
     * @var Address
     */
    private $deliveryAddress;

    public function __construct(string $firstName, string $lastName, Address $billingAddress, Address $deliveryAddress)
    {
        if ($firstName === '') {
            throw new CustomerFirstNameIsEmpty();
        }
        if ($lastName === '') {
            throw new CustomerFirstNameIsEmpty();
        }
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->billingAddress = $billingAddress;
        $this->deliveryAddress = $deliveryAddress;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function billingAddress(): Address
    {
        return $this->billingAddress;
    }

    public function deliveryAddress(): Address
    {
        return $this->deliveryAddress;
    }

    public function isEqual(self $customerDetails): bool
    {
        return
            $this->firstName === $customerDetails->firstName &&
            $this->lastName === $customerDetails->lastName &&
            $this->billingAddress->isEquals($customerDetails->billingAddress) &&
            $this->deliveryAddress->isEquals($customerDetails->deliveryAddress);
    }

    private function __clone()
    {
    }
}
