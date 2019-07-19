<?php

declare(strict_types=1);

use OrderService\Events\OrderWasDelivered;
use OrderService\Events\OrderWasPaid;
use OrderService\Events\OrderWasPlaced;
use OrderService\Events\OrderWasRefunded;
use OrderService\Events\OrderWasShipped;
use OrderService\Projectors\MostRefundedBooks;
use OrderService\Projectors\MostSoldBooks;
use OrderService\Projectors\Orders;
use OrderService\Reactors\SorryEmail;
use OrderService\Serializers\EventSerializer;
use OrderService\Serializers\OrderWasDeliveredSerializer;
use OrderService\Serializers\OrderWasPaidSerializer;
use OrderService\Serializers\OrderWasPlacedSerializer;
use OrderService\Serializers\OrderWasRefundedSerializer;
use OrderService\Serializers\OrderWasShippedSerializer;
use Spatie\EventSourcing\HandleStoredEventJob;
use Spatie\EventSourcing\Models\EloquentStoredEvent;

return [
    /*
     * These directories will be scanned for projectors and reactors. They
     * will be automatically registered to projectionist automatically.
     */
    'auto_discover_projectors_and_reactors' => [
        app_path(),
    ],

    /*
     * Projectors are classes that build up projections. You can create them by performing
     * `php artisan event-projector:create-projector`.  When not using auto-discovery
     * Projectors can be registered in this array or a service provider.
     */
    'projectors' => [
        Orders::class,
        MostRefundedBooks::class,
        MostSoldBooks::class,
    ],

    /*
     * Reactors are classes that handle side effects. You can create them by performing
     * `php artisan event-projector:create-reactor`. When not using auto-discovery
     * Reactors can be registered in this array or a service provider.
     */
    'reactors' => [
        SorryEmail::class,
    ],

    /*
     * A queue is used to guarantee that all events get passed to the projectors in
     * the right order. Here you can set of the name of the queue.
     */
    'queue' => env('EVENT_PROJECTOR_QUEUE_NAME', null),

    /*
     * When a projector or reactor throws an exception the event projectionist can catch it
     * so all other projectors and reactors can still do their work. The exception will
     * be passed to the `handleException` method on that projector or reactor.
     */
    'catch_exceptions' => env('EVENT_PROJECTOR_CATCH_EXCEPTIONS', false),

    /*
     * This class is responsible for storing events. To add extra behaviour you
     * can change this to a class of your own. The only restriction is that
     * it should extend \Spatie\EventProjector\Models\StoredEvent.
     */
    'stored_event_model' => EloquentStoredEvent::class,

    /*
     * This class is responsible for handle stored events. To add extra behaviour you
     * can change this to a class of your own. The only restriction is that
     * it should extend \Spatie\EventProjector\HandleDomainEventJob.
     */
    'stored_event_job' => HandleStoredEventJob::class,

    /*
     * Similar to Relation::morphMap() you can define which alias responds to which
     * event class. This allows you to change the namespace or classnames
     * of your events but still handle older events correctly.
     */
    'event_class_map' => [
        'order_was_placed' => OrderWasPlaced::class,
        'order_was_paid' => OrderWasPaid::class,
        'order_was_shipped' => OrderWasShipped::class,
        'order_was_delivered' => OrderWasDelivered::class,
        'order_was_refunded' => OrderWasRefunded::class,
    ],

    /*
     * This class is responsible for serializing events. By default an event will be serialized
     * and stored as json. You can customize the class name. A valid serializer
     * should implement Spatie\EventProjector\EventSerializers\Serializer.
     */
    'event_serializer' => EventSerializer::class,

    /*
    * This array is responsible for mapping the serializer with its own event.
    * In order to customize the serialization behaviour for each event we need to specify how do we want to map it.
    */
    'event_class_serializer_map' => [
        OrderWasPlacedSerializer::class => OrderWasPlaced::class,
        OrderWasPaidSerializer::class => OrderWasPaid::class,
        OrderWasShippedSerializer::class => OrderWasShipped::class,
        OrderWasDeliveredSerializer::class => OrderWasDelivered::class,
        OrderWasRefundedSerializer::class => OrderWasRefunded::class,
    ],

    /*
     * When replaying events potentially a lot of events will have to be retrieved.
     * In order to avoid memory problems events will be retrieved in
     * a chunked way. You can specify the chunk size here.
     */
    'replay_chunk_size' => 1000,

    /*
     * In production, you likely don't want the package to auto discover the event handlers
     * on every request. The package can cache all registered event handlers.
     * More info: https://docs.spatie.be/laravel-event-projector/v3/advanced-usage/discovering-projectors-and-reactors
     *
     * Here you can specify where the cache should be stored.
     */
    'cache_path' => storage_path('app/event-projector'),
];
