<?php

declare(strict_types=1);

namespace OrderService\ValueObjects;

use OrderService\ValueObjects\Exception\InvalidID;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CustomerID
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @throws InvalidID
     */
    public static function fromUUID(string $uuid): self
    {
        try {
            return new self(Uuid::fromString($uuid));
        } catch (InvalidUuidStringException $e) {
            throw new InvalidID($uuid, $e);
        }
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function isEquals(self $uuid): bool
    {
        return (string) $uuid === $this->uuid->toString();
    }

    private function __clone()
    {
    }
}
