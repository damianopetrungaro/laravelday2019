<?php

declare(strict_types=1);

namespace OrderService\Serializers;

use function config;
use OrderService\Serializers\Exception\SerializerIsNotAvailable;
use Spatie\EventSourcing\EventSerializers\EventSerializer as SpatieSerializer;
use Spatie\EventSourcing\ShouldBeStored;

final class EventSerializer implements SpatieSerializer
{
    /**
     * @var array
     */
    private $map;

    public function __construct()
    {
        $this->map = config('event-sourcing.event_class_serializer_map');
    }

    public function serialize(ShouldBeStored $event): string
    {
        $serializer = \array_search(\get_class($event), $this->map, true);

        if (!$serializer || !\in_array(SpatieSerializer::class, \class_implements($serializer), true)) {
            throw new SerializerIsNotAvailable(\get_class($event));
        }

        /** @var SpatieSerializer $serializer */
        $serializer = new $serializer();

        return $serializer->serialize($event);
    }

    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        $serializer = \array_search($eventClass, $this->map, true);
        if (!$serializer || !\in_array(SpatieSerializer::class, \class_implements($serializer), true)) {
            throw new SerializerIsNotAvailable($eventClass);
        }

        /** @var SpatieSerializer $serializer */
        $serializer = new $serializer();

        return $serializer->deserialize($eventClass, $json);
    }
}
