<?php

namespace OrderService\Serializers;

use OrderService\Serializers\Exception\SerializerIsNotAvailable;
use Spatie\EventProjector\EventSerializers\EventSerializer as SpatieSerializer;
use Spatie\EventProjector\ShouldBeStored;
use function array_search;
use function class_implements;
use function config;
use function get_class;
use function in_array;

final class EventSerializer implements SpatieSerializer
{
    /**
     * @var array
     */
    private $map;

    public function __construct()
    {
        $this->map = config('event-projector.event_class_serializer');
    }

    public function serialize(ShouldBeStored $event): string
    {
        $serializer = array_search(get_class($event), $this->map, true);
        if (!$serializer || !in_array(SpatieSerializer::class, class_implements($serializer),true)) {
            throw new SerializerIsNotAvailable(get_class($event));
        }

        /** @var SpatieSerializer $serializer */
        $serializer = new $serializer();
        return $serializer->serialize($event);
    }

    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        $serializer = array_search($eventClass, $this->map, true);
        if (!$serializer || !in_array(SpatieSerializer::class, class_implements($serializer),true)) {
            throw new SerializerIsNotAvailable($eventClass);
        }

        /** @var SpatieSerializer $serializer */
        $serializer = new $serializer();

        return $serializer->deserialize($eventClass, $json);
    }
}
