<?php

declare(strict_types=1);

namespace OrderService\Repository\Instrumentation;

use OrderService\Aggregates\Order;
use OrderService\ValueObjects\ID;
use Psr\Log\LoggerInterface;

final class RepositoryInstrumentation
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function errorAddingTheOrder(Order $order, \Throwable $e)
    {
        $this->logger->alert('an error occurred adding events to an order aggregate', ['id' => $order->ID(), 'exception' => $e]);
    }

    public function errorGettingTheOrder(ID $ID, \Throwable $e)
    {
        $this->logger->alert('an error occurred getting an order aggregate', ['id' => $ID, 'exception' => $e]);
    }
}
