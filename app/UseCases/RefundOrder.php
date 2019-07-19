<?php

declare(strict_types=1);

namespace OrderService\UseCases;

use Money\Money;
use OrderService\Repository\OrderRepository;
use OrderService\ValueObjects\ID;
use OrderService\ValueObjects\UserID;

final class RefundOrder
{
    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ID $ID, Money $amount, UserID $userID): void
    {
        $order = $this->repository->getByID($ID);
        $order->refund($amount, $userID);
        $this->repository->add($order);
    }
}
