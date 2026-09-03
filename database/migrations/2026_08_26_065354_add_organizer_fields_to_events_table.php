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
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'organizer_id')) {
                $table->foreignId('organizer_id')->nullable()->constrained('users')->cascadeOnDelete();
            }
            if (Schema::hasColumn('events', 'event_date')) {
                $table->dropColumn(['event_date', 'start_time', 'end_time', 'price', 'quota', 'address']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('quota')->nullable();
            $table->text('address')->nullable();
        });
    }
};
