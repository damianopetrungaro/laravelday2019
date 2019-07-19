<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateStoredEventsTable extends Migration
{
    public function up(): void
    {
        Schema::create('stored_events', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('aggregate_uuid')->nullable();
            $table->string('event_class');
            $table->json('event_properties');
            $table->json('meta_data');
            $table->timestamp('created_at');
            $table->index('event_class');
            $table->index('aggregate_uuid');
        });
    }
}
