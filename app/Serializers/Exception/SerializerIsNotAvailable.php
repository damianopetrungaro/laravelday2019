<?php
declare(strict_types=1);

namespace OrderService\Serializers\Exception;

use InvalidArgumentException;
use Throwable;
use function sprintf;

final class SerializerIsNotAvailable extends InvalidArgumentException
{
    private const ERROR_MESSAGE = 'There is no serializer loaded for the event of type: "%s"';

    public function __construct(string $className, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::ERROR_MESSAGE, $className), $code = 0, $previous);
    }
}
