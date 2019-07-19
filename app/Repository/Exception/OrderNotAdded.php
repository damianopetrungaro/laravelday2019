<?php

declare(strict_types=1);

namespace OrderService\Repository\Exception;

use OrderService\ValueObjects\ID;
use Throwable;

final class OrderNotAdded extends \RuntimeException
{
    private const ERROR_MESSAGE_FORMAT = 'An error occurred adding the order with ID "%s" to the persistence.';

    public function __construct(ID $ID, Throwable $previous = null)
    {
        $message = \sprintf(self::ERROR_MESSAGE_FORMAT, (string) $ID);
        parent::__construct($message, $code = 0, $previous);
    }
}
