<?php

declare(strict_types=1);

namespace Tests\Feature;

use OrderService\Aggregates\Order;
use Tests\TestCase;

class PlaceOrderAPITest extends TestCase
{
    /**
     * @dataProvider placeOrderInvalidBodyDataProvider
     */
    public function testFailureOnPlaceOrder(array $body, string $want): void
    {
        $response = $this->post('api/orders', $body);
        $response->assertStatus(422);
        $this->assertSame($want, $response->getContent());
    }

    /**
     * @dataProvider placeOrderBodyDataProvider
     */
    public function testPlaceOrder(array $body): void
    {
        $response = $this->post('api/orders', $body);
        $response->assertStatus(201);

        $id = \explode('/', $response->headers->get('Location'))[2] ?? '';
        /** @var Order $order */
        $order = Order::retrieve($id);
        $customerDetails = $order->customerDetails();
        $bookDetails = $order->bookDetails();
        $billingAddress = $customerDetails->billingAddress();
        $deliveryAddress = $customerDetails->deliveryAddress();
        $this->assertSame($id, (string) $order->ID());
        $this->assertSame($body['book_id'], (string) $order->bookID());
        $this->assertSame($body['book_title'], $bookDetails->title());
        $this->assertSame($body['book_author'], $bookDetails->author());
        $this->assertSame($body['book_price_amount'], $bookDetails->price()->getAmount());
        $this->assertSame($body['book_price_currency'], $bookDetails->price()->getCurrency()->getCode());
        $this->assertSame($body['customer_id'], (string) $order->customerID());
        $this->assertSame($body['customer_first_name'], $customerDetails->firstName());
        $this->assertSame($body['customer_last_name'], $customerDetails->lastName());
        $this->assertSame($body['customer_billing_address']['street'], $billingAddress->street());
        $this->assertSame($body['customer_billing_address']['city'], $billingAddress->city());
        $this->assertSame($body['customer_billing_address']['state'], $billingAddress->state());
        $this->assertSame($body['customer_billing_address']['country'], $billingAddress->country());
        $this->assertSame($body['customer_billing_address']['ring_name'], $billingAddress->ringName());
        $this->assertSame($body['customer_billing_address']['zip_code'], $billingAddress->zipCode());
        $this->assertSame($body['customer_delivery_address']['street'], $deliveryAddress->street());
        $this->assertSame($body['customer_delivery_address']['city'], $deliveryAddress->city());
        $this->assertSame($body['customer_delivery_address']['state'], $deliveryAddress->state());
        $this->assertSame($body['customer_delivery_address']['country'], $deliveryAddress->country());
        $this->assertSame($body['customer_delivery_address']['ring_name'], $deliveryAddress->ringName());
        $this->assertSame($body['customer_delivery_address']['zip_code'], $deliveryAddress->zipCode());
    }

    public function placeOrderBodyDataProvider(): array
    {
        return [
            [
                \json_decode('{
   "book_title":"Book title",
   "book_author":"Book Author",
   "book_price_amount":"1000",
   "book_price_currency":"EUR",
   "book_id":"004773df-6551-3f6b-b2dd-1d823a67198b",
   "customer_id":"050a0ff4-196f-343d-80c7-97ac34b49135",
   "customer_first_name":"Damiano",
   "customer_last_name":"Petrungaro",
   "customer_billing_address":{
      "street":"Heynstrasse 16 A",
      "city":"Berlin",
      "state":"-",
      "country":"Germany",
      "ring_name":"Damiano P.",
      "zip_code":"14159"
   },
   "customer_delivery_address":{
      "street":"Heynstrasse 16 A",
      "city":"Berlin",
      "state":"-",
      "country":"Germany",
      "ring_name":"-",
      "zip_code":"14159"
   }
}', true),
            ],
        ];
    }

    public function placeOrderInvalidBodyDataProvider()
    {
        return [
            [[], 'customer ID does not exists'],
        ];
    }
}
