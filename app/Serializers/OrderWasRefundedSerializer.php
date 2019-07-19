<?php

declare(strict_types=1);

namespace OrderService\Serializers;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use OrderService\Events\OrderWasRefunded;
use OrderService\Serializers\Exception\EventIsInvalid;
use OrderService\Serializers\Exception\UnableToSerialize;
use OrderService\ValueObjects\UserID;
use Spatie\EventSourcing\EventSerializers\EventSerializer;
use Spatie\EventSourcing\ShouldBeStored;
use Throwable;

final class OrderWasRefundedSerializer implements EventSerializer
{
    private const TIME_FORMAT = 'Y-m-f H:i:s';

    /**
     * @param OrderWasRefunded $event
     */
    public function serialize(ShouldBeStored $event): string
    {
        if (OrderWasRefunded::class !== \get_class($event)) {
            throw new EventIsInvalid(OrderWasRefunded::class, \get_class($event));
        }

        return \GuzzleHttp\json_encode([
            'price' => [
                'amount' => $event->amount()->getAmount(),
                'currency' => $event->amount()->getCurrency()->getCode(),
            ],
            'refundedAt' => $event->refundedAt()->format(self::TIME_FORMAT),
            'refundedBy' => (string) $event->refundedBy(),
        ]);
    }

    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        if (OrderWasRefunded::class !== $eventClass) {
            throw new EventIsInvalid(OrderWasRefunded::class, $eventClass);
        }

        $event = \json_decode($json, true);

        try {
            $refundedBy = UserID::fromUUID($event['refundedBy']);
            $amount = new Money($event['price']['amount'], new Currency($event['price']['currency']));
            $refundedAt = DateTimeImmutable::createFromFormat(self::TIME_FORMAT, $event['refundedAt']);
        } catch (Throwable $e) {
            throw new UnableToSerialize($eventClass, $e);
        }

        return new OrderWasRefunded($amount, $refundedBy, $refundedAt);
    }
}
