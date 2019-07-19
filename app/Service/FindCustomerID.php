<?php

declare(strict_types=1);

namespace OrderService\Service;

use OrderService\Model\Customer;
use OrderService\ValueObjects\CustomerID;

final class FindCustomerID
{
    public function __invoke(string $id): ?CustomerID
    {
        if (!$customer = Customer::find($id)) {
            return null;
        }

        try {
            return CustomerID::fromUUID($customer['id']);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
