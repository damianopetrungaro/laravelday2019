<?php

declare(strict_types=1);

namespace OrderService\UseCases;

use Money\Money;
use OrderService\Repository\OrderRepository;
use OrderService\ValueObjects\ID;
use OrderService\ValueObjects\UserID;

final class MarkOrderAsRefunded
{
    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ID $ID, Money $amount, UserID $refundedBy): void
    {
        $order = $this->repository->getByID($ID);
        $order->refund($amount, $refundedBy);
        $this->repository->add($order);
    }
}
