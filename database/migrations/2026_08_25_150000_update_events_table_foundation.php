<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'organizer_id')) {
                $table->foreignId('organizer_id')->nullable()->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('events', 'event_type')) {
                $table->string('event_type')->default('offline');
            }
            if (!Schema::hasColumn('events', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('events', 'online_url')) {
                $table->string('online_url')->nullable();
            }
            if (!Schema::hasColumn('events', 'start_at')) {
                $table->dateTime('start_at')->nullable();
            }
            if (!Schema::hasColumn('events', 'end_at')) {
                $table->dateTime('end_at')->nullable();
            }
            if (!Schema::hasColumn('events', 'timezone')) {
                $table->string('timezone')->default('Asia/Jakarta');
            }
            if (!Schema::hasColumn('events', 'capacity')) {
                $table->unsignedInteger('capacity')->default(100);
            }
            if (!Schema::hasColumn('events', 'registration_deadline')) {
                $table->dateTime('registration_deadline')->nullable();
            }
            if (!Schema::hasColumn('events', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $columns = [
                'organizer_id', 'event_type', 'city', 'online_url',
                'start_at', 'end_at', 'timezone', 'capacity',
                'registration_deadline', 'rejection_reason'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
