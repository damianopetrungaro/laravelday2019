<?php

declare(strict_types=1);

namespace OrderService\ValueObjects\Exception;

use InvalidArgumentException;
use Throwable;

final class CustomerLastNameIsEmpty extends InvalidArgumentException
{
    private const ERROR_MESSAGE = "The last name can't be empty.";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(self::ERROR_MESSAGE, $code = 0, $previous);
    }
}
