<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            Schema::table('calendar_events', function (Blueprint $table) {
                $table->integer('capacity');
                $table->string('image')->nullable();
                $table->decimal('ticket_price', 8, 2)->nullable()->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            Schema::table('calendar_events', function (Blueprint $table) {
                $table->dropColumn('capacity');
                $table->dropColumn('image');
                $table->decimal('ticket_price', 8, 2)->nullable()->default(0);
            });
        });
    }
};
