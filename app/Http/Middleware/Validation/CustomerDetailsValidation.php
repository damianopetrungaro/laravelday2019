<?php

declare(strict_types=1);

namespace OrderService\Http\Middleware\Validation;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OrderService\ValueObjects\Address;
use OrderService\ValueObjects\CustomerDetails;
use OrderService\ValueObjects\Exception\AddressCityIsEmpty;
use OrderService\ValueObjects\Exception\AddressCountryIsEmpty;
use OrderService\ValueObjects\Exception\AddressRingNameIsEmpty;
use OrderService\ValueObjects\Exception\AddressStateIsEmpty;
use OrderService\ValueObjects\Exception\AddressStreetIsEmpty;
use OrderService\ValueObjects\Exception\AddressZipCodeIsEmpty;
use OrderService\ValueObjects\Exception\CustomerFirstNameIsEmpty;

final class CustomerDetailsValidation
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $details = new CustomerDetails(
                $request->get('customer_first_name', ''),
                $request->get('customer_last_name', ''),
                $this->address($request->get('customer_billing_address', [])),
                $this->address($request->get('customer_delivery_address', []))
            );
            $request[CustomerDetails::class] = $details;
        } catch (
        CustomerFirstNameIsEmpty |
        CustomerFirstNameIsEmpty |
        AddressStreetIsEmpty |
        AddressCityIsEmpty |
        AddressStateIsEmpty |
        AddressCountryIsEmpty |
        AddressZipCodeIsEmpty |
        AddressRingNameIsEmpty $e
        ) {
            return new Response($e->getMessage(), 422);
        }

        return $next($request);
    }

    private function address(array $address): Address
    {
        return new Address(
            $address['street'] ?? '',
            $address['city'] ?? '',
            $address['state'] ?? '',
            $address['country'] ?? '',
            $address['zip_code'] ?? '',
            $address['ring_name'] ?? '',
        );
    }
}
