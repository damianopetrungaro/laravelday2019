<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        Schema::create('customers', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('shipping_address');
            $table->string('billing_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}
