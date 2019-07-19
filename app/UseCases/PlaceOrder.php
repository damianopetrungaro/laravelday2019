<?php

declare(strict_types=1);

namespace OrderService\UseCases;

use OrderService\Aggregates\Order;
use OrderService\Repository\OrderRepository;
use OrderService\ValueObjects\BookDetails;
use OrderService\ValueObjects\BookID;
use OrderService\ValueObjects\CustomerDetails;
use OrderService\ValueObjects\CustomerID;

final class PlaceOrder
{
    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CustomerID $customerID, CustomerDetails $customerDetails, BookID $bookID, BookDetails $bookDetails): Order
    {
        $order = Order::place(
            $this->repository->nextID(),
            $customerID,
            $customerDetails,
            $bookID,
            $bookDetails
        );

        $this->repository->add($order);

        return $order;
    }
}
