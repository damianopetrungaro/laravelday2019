<?php

declare(strict_types=1);

namespace OrderService\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;

    public function getKeyType(): string
    {
        return 'string';
    }
}
