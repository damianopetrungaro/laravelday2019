<?php

declare(strict_types=1);

namespace OrderService\Projectors\Instrumentation;

use OrderService\Projectors\MostRefundedBooks;
use Psr\Log\LoggerInterface;

final class MostRefundedBooksInstrumentation
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function errorOnOrderWasRefunded(string $ID): void
    {
        $this->logger->warning('error on order was refunded event', ['id' => $ID, 'projector' => MostRefundedBooks::class]);
    }
}
