<?php

declare(strict_types=1);

namespace OrderService\Console\Commands;

use Illuminate\Console\Command;
use OrderService\UseCases\MarkOrderAsDelivered as UseCase;
use OrderService\ValueObjects\Exception\InvalidID;
use OrderService\ValueObjects\ID;

class MarkOrderAsDelivered extends Command
{
    /**
     * @var string
     */
    protected $signature = 'order:delivered {id}';

    /**
     * @var string
     */
    protected $description = 'Mark an order as delivered';

    /**
     * @var UseCase
     */
    private $useCase;

    public function __construct(UseCase $useCase)
    {
        parent::__construct();
        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        /** @var string $argumentID */
        $argumentID = $this->argument('id');

        try {
            $id = ID::fromUUID($argumentID);
        } catch (InvalidID $e) {
            $this->output->error("parsing ID: {$e->getMessage()}");

            return;
        }

        try {
            ($this->useCase)($id);
        } catch (\Throwable $e) {
            $this->output->error($e->getMessage());

            return;
        }

        $this->output->success('Order has been marked as delivered');
    }
}
