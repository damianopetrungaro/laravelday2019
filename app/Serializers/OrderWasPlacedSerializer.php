<?php

declare(strict_types=1);

namespace OrderService\Serializers;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use OrderService\Events\OrderWasPlaced;
use OrderService\Serializers\Exception\EventIsInvalid;
use OrderService\Serializers\Exception\UnableToSerialize;
use OrderService\ValueObjects\Address;
use OrderService\ValueObjects\BookDetails;
use OrderService\ValueObjects\BookID;
use OrderService\ValueObjects\CustomerDetails;
use OrderService\ValueObjects\CustomerID;
use OrderService\ValueObjects\ID;
use Spatie\EventSourcing\EventSerializers\EventSerializer;
use Spatie\EventSourcing\ShouldBeStored;
use Throwable;

final class OrderWasPlacedSerializer implements EventSerializer
{
    private const TIME_FORMAT = 'Y-m-f H:i:s';

    /**
     * @param OrderWasPlaced $event
     */
    public function serialize(ShouldBeStored $event): string
    {
        if (OrderWasPlaced::class !== \get_class($event)) {
            throw new EventIsInvalid(OrderWasPlaced::class, \get_class($event));
        }

        $customerDetails = $event->customerDetails();
        $bookDetails = $event->bookDetails();
        $deliveryAddress = $customerDetails->deliveryAddress();
        $billingAddress = $customerDetails->billingAddress();

        return \GuzzleHttp\json_encode([
            'ID' => (string) $event->ID(),
            'customerID' => (string) $event->customerID(),
            'customerDetails' => [
                'firstName' => $customerDetails->firstName(),
                'lastName' => $customerDetails->lastName(),
                'billingAddress' => [
                    'street' => $billingAddress->street(),
                    'city' => $billingAddress->city(),
                    'state' => $billingAddress->state(),
                    'country' => $billingAddress->country(),
                    'zipCode' => $billingAddress->zipCode(),
                    'ringName' => $billingAddress->ringName(),
                ],
                'deliveryAddress' => [
                    'street' => $deliveryAddress->street(),
                    'city' => $deliveryAddress->city(),
                    'state' => $deliveryAddress->state(),
                    'country' => $deliveryAddress->country(),
                    'zipCode' => $deliveryAddress->zipCode(),
                    'ringName' => $deliveryAddress->ringName(),
                ],
            ],
            'bookID' => (string) $event->bookID(),
            'bookDetails' => [
                'title' => $bookDetails->title(),
                'author' => $bookDetails->author(),
                'price' => [
                    'amount' => $bookDetails->price()->getAmount(),
                    'currency' => $bookDetails->price()->getCurrency()->getCode(),
                ],
            ],
            'placedAt' => $event->placedAt()->format(self::TIME_FORMAT),
        ]);
    }

    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        if (OrderWasPlaced::class !== $eventClass) {
            throw new EventIsInvalid(OrderWasPlaced::class, $eventClass);
        }

        $event = \json_decode($json, true);

        try {
            $ID = ID::fromUUID($event['ID']);
            $customerID = CustomerID::fromUUID($event['customerID']);
            $customerDetails = new CustomerDetails(
                $event['customerDetails']['firstName'],
                $event['customerDetails']['lastName'],
                new Address(
                    $event['customerDetails']['billingAddress']['street'],
                    $event['customerDetails']['billingAddress']['city'],
                    $event['customerDetails']['billingAddress']['state'],
                    $event['customerDetails']['billingAddress']['country'],
                    $event['customerDetails']['billingAddress']['zipCode'],
                    $event['customerDetails']['billingAddress']['ringName']
                ),
                new Address(
                    $event['customerDetails']['deliveryAddress']['street'],
                    $event['customerDetails']['deliveryAddress']['city'],
                    $event['customerDetails']['deliveryAddress']['state'],
                    $event['customerDetails']['deliveryAddress']['country'],
                    $event['customerDetails']['deliveryAddress']['zipCode'],
                    $event['customerDetails']['deliveryAddress']['ringName']
                ),
            );
            $bookID = BookID::fromUUID($event['bookID']);
            $bookDetails = new BookDetails(
                $event['bookDetails']['title'],
                $event['bookDetails']['author'],
                new Money($event['bookDetails']['price']['amount'], new Currency($event['bookDetails']['price']['currency']))
            );
            $placedAt = DateTimeImmutable::createFromFormat(self::TIME_FORMAT, $event['placedAt']);
        } catch (Throwable $e) {
            throw new UnableToSerialize($eventClass, $e);
        }

        return new OrderWasPlaced($ID, $customerID, $customerDetails, $bookID, $bookDetails, $placedAt);
    }
}
