<?php
declare(strict_types=1);

namespace OrderService\Aggregates\Exception;

use DomainException;
use OrderService\ValueObjects\ID;
use Throwable;
use function sprintf;

final class OrderIsAlreadyPaid extends DomainException
{
    private const ERROR_MESSAGE_FORMAT = 'The order with ID "%s" is already paid.';

    public function __construct(ID $ID, Throwable $previous = null)
    {
        $message = sprintf(self::ERROR_MESSAGE_FORMAT, (string)$ID);
        parent::__construct($message, $code = 0, $previous);
    }
}
