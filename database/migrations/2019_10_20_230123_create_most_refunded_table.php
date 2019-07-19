<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateMostRefundedTable extends Migration
{
    public function up(): void
    {
        Schema::create('most_refunded', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('refunds')->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('most_refunded');
    }
}
