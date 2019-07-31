<?php
declare(strict_types=1);

namespace OrderService\ValueObjects\Exception;

use InvalidArgumentException;
use Throwable;
use function sprintf;

final class InvalidID extends InvalidArgumentException
{
    private const ERROR_MESSAGE_FORMAT = 'The value is not valid. Given "%s"';

    public function __construct($invalidValue, Throwable $previous = null)
    {
        $message = sprintf(self::ERROR_MESSAGE_FORMAT, $invalidValue);
        parent::__construct($message, $code = 0, $previous);
    }
}
