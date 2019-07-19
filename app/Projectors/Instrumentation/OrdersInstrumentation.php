<?php

declare(strict_types=1);

namespace OrderService\Projectors\Instrumentation;

use OrderService\Projectors\Orders;
use Psr\Log\LoggerInterface;

final class OrdersInstrumentation
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function errorOnOrderWasPlaced(string $ID): void
    {
        $this->logger->warning('error on order was placed event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotFoundOnOrderWasPaid(string $ID): void
    {
        $this->logger->warning('error order not found on order was paid event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotUpdatedOnOrderWasPaid(string $ID): void
    {
        $this->logger->warning('error order not updated on order was paid event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotFoundOnOrderWasShipped(string $ID): void
    {
        $this->logger->warning('error order not found on order was shipped event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotUpdatedOnOrderWasShipped(string $ID): void
    {
        $this->logger->warning('error order not updated on order was shipped event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotFoundOnOrderWasDelivered(string $ID): void
    {
        $this->logger->warning('error order not found on order was delivered event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotUpdatedOnOrderWasDelivered(string $ID): void
    {
        $this->logger->warning('error order not updated on order was delivered event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotFoundOnOrderWasRefunded(string $ID): void
    {
        $this->logger->warning('error order not found on order was refunded event', ['id' => $ID, 'projector' => Orders::class]);
    }

    public function errorOrderNotUpdatedOnOrderWasRefunded(string $ID): void
    {
        $this->logger->warning('error order not updated on order was refunded event', ['id' => $ID, 'projector' => Orders::class]);
    }
}
