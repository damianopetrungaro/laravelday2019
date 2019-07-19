<?php

declare(strict_types=1);

namespace OrderService\Model;

use Illuminate\Database\Eloquent\Model;

class MostSoldBook extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'book_id',
        'customer_id',
        'paid',
        'shipped',
        'delivered',
        'refunded',
        'refunded_by',
    ];
}
