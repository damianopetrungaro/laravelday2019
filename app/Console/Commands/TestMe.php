<?php

namespace OrderService\Console\Commands;

use Illuminate\Console\Command;
use Money\Currency;
use Money\Money;
use OrderService\Aggregates\Order;
use OrderService\ValueObjects\Address;
use OrderService\ValueObjects\BookDetails;
use OrderService\ValueObjects\BookID;
use OrderService\ValueObjects\CustomerDetails;
use OrderService\ValueObjects\CustomerID;
use OrderService\ValueObjects\ID;
use Ramsey\Uuid\Uuid;
use function var_dump;

class TestMe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ID = ID::fromUUID(Uuid::uuid4()->toString());
        $customerID = CustomerID::fromUUID(Uuid::uuid4()->toString());
        $address = new Address('steeet', 'city', 'state', 'country', 'zipcode', 'DP');
        $customerDetails = new CustomerDetails('Dami', 'Petr', $address, $address);
        $bookID = BookID::fromUUID(Uuid::uuid4()->toString());
        $bookDetails = new BookDetails('title', 'author', new Money(1990, new Currency('USD')));

        $order = Order::place($ID, $customerID, $customerDetails, $bookID, $bookDetails);
        $order->persist();
        var_dump((string)$ID);
        $retrived = Order::retrieve((string)$ID);
        /** @var Order $retrived */
        var_dump($retrived);
    }
}
