<?php

declare(strict_types=1);

namespace OrderService\Projectors\Instrumentation;

use OrderService\Projectors\MostSoldBooks;
use Psr\Log\LoggerInterface;

final class MostSoldBooksInstrumentation
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
        $this->logger->warning('error on order was placed event', ['id' => $ID, 'projector' => MostSoldBooks::class]);
    }
}
