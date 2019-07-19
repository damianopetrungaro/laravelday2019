<?php

declare(strict_types=1);

namespace OrderService\Reactors;

use OrderService\Events\OrderWasDelivered;
use Spatie\EventSourcing\EventHandlers\EventHandler;
use Spatie\EventSourcing\EventHandlers\HandlesEvents;
use Spatie\EventSourcing\StoredEvent;

final class SorryEmail implements EventHandler
{
    use HandlesEvents;

    public function onOrderWasDelivered(OrderWasDelivered $event, StoredEvent $storedEvent)
    {
        // Dispatch a message to the customer service in order to send a sorry-email if the dispatch took too long
    }
}
