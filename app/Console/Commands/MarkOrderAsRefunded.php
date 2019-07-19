<?php

declare(strict_types=1);

namespace OrderService\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use OrderService\Aggregates\Exception\OrderIsAlreadyShipped;
use OrderService\Service\FindUserID;
use OrderService\UseCases\MarkOrderAsRefunded as UseCase;
use OrderService\ValueObjects\Exception\InvalidID;
use OrderService\ValueObjects\ID;

class MarkOrderAsRefunded extends Command
{
    /**
     * @var string
     */
    protected $signature = 'order:refunded {id} {user_id} {amount} {currency}';

    /**
     * @var string
     */
    protected $description = 'Mark an order as refunded';

    /**
     * @var UseCase
     */
    private $useCase;

    /**
     * @var FindUserID
     */
    private $findUserID;

    public function __construct(UseCase $useCase, FindUserID $findUserID)
    {
        parent::__construct();
        $this->useCase = $useCase;
        $this->findUserID = $findUserID;
    }

    public function handle(): void
    {
        /** @var string $argumentID */
        $argumentID = $this->argument('id');
        /** @var string $argumentUserID */
        $argumentUserID = $this->argument('user_id');
        /** @var string $argumentAmount */
        $argumentAmount = $this->argument('amount');
        /** @var string $argumentCurrency */
        $argumentCurrency = $this->argument('currency');

        try {
            $id = ID::fromUUID($argumentID);
        } catch (InvalidID $e) {
            $this->output->error("parsing ID: {$e->getMessage()}");

            return;
        }

        try {
            $amount = new Money($argumentAmount, new Currency($argumentCurrency));
        } catch (InvalidArgumentException $e) {
            $this->output->warning($e->getMessage());

            return;
        }

        if (!$userID = ($this->findUserID)($argumentUserID)) {
            $this->output->error("user ID not found: {$argumentUserID}");

            return;
        }

        try {
            ($this->useCase)($id, $amount, $userID);
        } catch (OrderIsAlreadyShipped $e) {
            $this->output->warning($e->getMessage());

            return;
        } catch (\Throwable $e) {
            $this->output->error($e->getMessage());

            return;
        }

        $this->output->success('Order has been marked as refunded');
    }
}
