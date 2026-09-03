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
            if (!Schema::hasColumn('events', 'event_type_id')) {
                $table->foreignId('event_type_id')->nullable()->constrained('event_types')->nullOnDelete();
            }
            if (!Schema::hasColumn('events', 'event_format_id')) {
                $table->foreignId('event_format_id')->nullable()->constrained('event_formats')->nullOnDelete();
            }
            if (!Schema::hasColumn('events', 'city_id')) {
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'event_type_id')) {
                $table->dropForeign(['event_type_id']);
                $table->dropColumn('event_type_id');
            }
            if (Schema::hasColumn('events', 'event_format_id')) {
                $table->dropForeign(['event_format_id']);
                $table->dropColumn('event_format_id');
            }
            if (Schema::hasColumn('events', 'city_id')) {
                $table->dropForeign(['city_id']);
                $table->dropColumn('city_id');
            }
        });
    }
};
