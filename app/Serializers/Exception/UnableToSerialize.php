<?php

declare(strict_types=1);

namespace OrderService\Serializers\Exception;

use InvalidArgumentException;
use Throwable;

final class UnableToSerialize extends InvalidArgumentException
{
    private const ERROR_MESSAGE = 'An error occurred replaying an event of type "%s"';

    public function __construct(string $className, Throwable $previous = null)
    {
        parent::__construct(\sprintf(self::ERROR_MESSAGE, $className), $code = 0, $previous);
    }
}
