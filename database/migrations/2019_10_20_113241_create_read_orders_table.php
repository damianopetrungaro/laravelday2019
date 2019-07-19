<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateReadOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('book_id')->nullable(false);
            $table->uuid('customer_id')->nullable(false);
            $table->boolean('paid')->default(false);
            $table->boolean('shipped')->default(false);
            $table->boolean('delivered')->default(false);
            $table->boolean('refunded')->default(false);
            $table->uuid('refunded_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
