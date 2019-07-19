<?php

declare(strict_types=1);

namespace OrderService\Aggregates;

use DateTimeImmutable;
use Money\Money;
use OrderService\Aggregates\Exception\OrderIsAlreadyDelivered;
use OrderService\Aggregates\Exception\OrderIsAlreadyPaid;
use OrderService\Aggregates\Exception\OrderIsAlreadyRefunded;
use OrderService\Aggregates\Exception\OrderIsAlreadyShipped;
use OrderService\Aggregates\Exception\OrderIsNotPaid;
use OrderService\Aggregates\Exception\OrderIsNotShipped;
use OrderService\Events\OrderWasDelivered;
use OrderService\Events\OrderWasPaid;
use OrderService\Events\OrderWasPlaced;
use OrderService\Events\OrderWasRefunded;
use OrderService\Events\OrderWasShipped;
use OrderService\ValueObjects\BookDetails;
use OrderService\ValueObjects\BookID;
use OrderService\ValueObjects\CustomerDetails;
use OrderService\ValueObjects\CustomerID;
use OrderService\ValueObjects\ID;
use OrderService\ValueObjects\UserID;
use Spatie\EventSourcing\AggregateRoot;

final class Order extends AggregateRoot
{
    /**
     * @var ID
     */
    private $ID;

    /**
     * @var CustomerID
     */
    private $customerID;

    /**
     * @var CustomerDetails
     */
    private $customerDetails;

    /**
     * @var BookID
     */
    private $bookID;

    /**
     * @var BookDetails
     */
    private $bookDetails;

    /**
     * @var DateTimeImmutable
     */
    private $placedAt;

    /**
     * @var DateTimeImmutable|null
     */
    private $paidAt;

    /**
     * @var DateTimeImmutable|null
     */
    private $shippedAt;

    /**
     * @var DateTimeImmutable|null
     */
    private $deliveredAt;

    /**
     * @var DateTimeImmutable|null
     */
    private $refundedAt;

    /**
     * @var UserID|null
     */
    private $refundedBy;

    /**
     * @var Money|null
     */
    private $refundAmount;

    public static function place(
        ID $ID,
        CustomerID $customerID,
        CustomerDetails $customerDetails,
        BookID $bookID,
        BookDetails $bookDetails
    ): self {
        /** @var self $order */
        $order = self::retrieve((string) $ID);
        $order->recordThat(new OrderWasPlaced($ID, $customerID, $customerDetails, $bookID, $bookDetails, new DateTimeImmutable()));

        return $order;
    }

    public function markAsPaid(): void
    {
        if (null !== $this->paidAt) {
            throw new OrderIsAlreadyPaid($this->ID);
        }

        $this->recordThat(new OrderWasPaid(new DateTimeImmutable()));
    }

    public function markAsShipped(): void
    {
        if (null === $this->paidAt) {
            throw new OrderIsNotPaid($this->ID);
        }

        if (null !== $this->shippedAt) {
            throw new OrderIsAlreadyShipped($this->ID);
        }

        $this->recordThat(new OrderWasShipped(new DateTimeImmutable()));
    }

    public function markAsDelivered(): void
    {
        if (null === $this->shippedAt) {
            throw new OrderIsNotShipped($this->ID);
        }

        if (null !== $this->deliveredAt) {
            throw new OrderIsAlreadyDelivered($this->ID);
        }

        $this->recordThat(new OrderWasDelivered(new DateTimeImmutable()));
    }

    public function refund(Money $amount, UserID $refundedBy): void
    {
        if (null === $this->paidAt) {
            throw new OrderIsNotPaid($this->ID);
        }

        if (null !== $this->refundedAt) {
            throw new OrderIsAlreadyRefunded($this->ID);
        }

        $this->recordThat(new OrderWasRefunded($amount, $refundedBy, new DateTimeImmutable()));
    }

    public function ID(): ID
    {
        return $this->ID;
    }

    public function customerID(): CustomerID
    {
        return $this->customerID;
    }

    public function customerDetails(): CustomerDetails
    {
        return $this->customerDetails;
    }

    public function bookID(): BookID
    {
        return $this->bookID;
    }

    public function bookDetails(): BookDetails
    {
        return $this->bookDetails;
    }

    public function placedAt(): DateTimeImmutable
    {
        return $this->placedAt;
    }

    public function paidAt(): ?DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function shippedAt(): ?DateTimeImmutable
    {
        return $this->shippedAt;
    }

    public function deliveredAt(): ?DateTimeImmutable
    {
        return $this->deliveredAt;
    }

    public function refundedAt(): ?DateTimeImmutable
    {
        return $this->refundedAt;
    }

    public function refundedBy(): ?UserID
    {
        return $this->refundedBy;
    }

    protected function applyOrderWasPlaced(OrderWasPlaced $event): void
    {
        $this->ID = $event->ID();
        $this->customerID = $event->customerID();
        $this->customerDetails = $event->customerDetails();
        $this->bookID = $event->bookID();
        $this->bookDetails = $event->bookDetails();
        $this->placedAt = $event->placedAt();
    }

    protected function applyOrderWasPaid(OrderWasPaid $event): void
    {
        $this->paidAt = $event->paidAt();
    }

    protected function applyOrderWasShipped(OrderWasShipped $event): void
    {
        $this->shippedAt = $event->shippedAt();
    }

    protected function applyOrderWasDelivered(OrderWasDelivered $event): void
    {
        $this->deliveredAt = $event->deliveredAt();
    }

    protected function applyOrderWasRefunded(OrderWasRefunded $event): void
    {
        $this->refundedBy = $event->refundedBy();
        $this->refundedAt = $event->refundedAt();
        $this->refundAmount = $event->amount();
    }

    public static function isValid(self $order): bool
    {
        return null !== $order->ID;
    }
}
