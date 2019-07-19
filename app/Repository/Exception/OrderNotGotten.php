<?php

declare(strict_types=1);

namespace OrderService\Repository\Exception;

use OrderService\ValueObjects\ID;
use Throwable;

final class OrderNotGotten extends \RuntimeException
{
    private const ERROR_MESSAGE_FORMAT = 'An error occurred getting the order with ID "%s" from the persistence.';

    public function __construct(ID $ID, Throwable $previous = null)
    {
        $message = \sprintf(self::ERROR_MESSAGE_FORMAT, (string) $ID);
        parent::__construct($message, $code = 0, $previous);
    }
}
