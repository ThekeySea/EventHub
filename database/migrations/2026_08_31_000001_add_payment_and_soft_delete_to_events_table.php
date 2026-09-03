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
            // Payment method: 'free', 'upfront', 'onsite'
            if (!Schema::hasColumn('events', 'payment_method')) {
                $table->string('payment_method')->default('free')->after('capacity');
            }

            // Payment info: organizer isi info transfer (rekening, dll)
            if (!Schema::hasColumn('events', 'payment_info')) {
                $table->text('payment_info')->nullable()->after('payment_method');
            }

            // Soft delete
            if (!Schema::hasColumn('events', 'deleted_at')) {
                $table->softDeletes()->after('rejection_reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('events', 'payment_info')) {
                $table->dropColumn('payment_info');
            }
            if (Schema::hasColumn('events', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
