<?php

declare(strict_types=1);

namespace OrderService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OrderService\UseCases\PlaceOrder;
use OrderService\ValueObjects\BookDetails;
use OrderService\ValueObjects\BookID;
use OrderService\ValueObjects\CustomerDetails;
use OrderService\ValueObjects\CustomerID;

final class PlaceOrderController extends Controller
{
    /**
     * @var PlaceOrder
     */
    private $placeOrder;

    public function __construct(PlaceOrder $placeOrder)
    {
        $this->placeOrder = $placeOrder;
    }

    public function __invoke(Request $request): Response
    {
        $order = ($this->placeOrder)(
            $request->get(CustomerID::class),
            $request->get(CustomerDetails::class),
            $request->get(BookID::class),
            $request->get(BookDetails::class),
        );

        return new Response('', 201, ['Location' => "/orders/{$order->ID()}"]);
    }
}
