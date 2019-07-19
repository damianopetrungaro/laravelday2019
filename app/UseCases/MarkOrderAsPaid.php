<?php

declare(strict_types=1);

namespace OrderService\UseCases;

use OrderService\Repository\OrderRepository;
use OrderService\ValueObjects\ID;

final class MarkOrderAsPaid
{
    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ID $ID): void
    {
        $order = $this->repository->getByID($ID);
        $order->markAsPaid();
        $this->repository->add($order);
    }
}
