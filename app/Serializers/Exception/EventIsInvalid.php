<?php
declare(strict_types=1);

namespace OrderService\Serializers\Exception;

use InvalidArgumentException;
use Throwable;
use function sprintf;

final class EventIsInvalid extends InvalidArgumentException
{
    private const ERROR_MESSAGE = 'The given event is not valid. Expected: "%s" given "%s"';

    public function __construct(string $expectedClassName, string $givenClassName, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::ERROR_MESSAGE, $expectedClassName, $givenClassName), $code = 0, $previous);
    }
}
