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
        Schema::table('event_registrations', function (Blueprint $table) {
            // Tambah cancelled_at jika belum ada
            if (!Schema::hasColumn('event_registrations', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('registered_at');
            }

            // Timestamp konfirmasi pembayaran oleh organizer
            if (!Schema::hasColumn('event_registrations', 'payment_confirmed_at')) {
                $table->timestamp('payment_confirmed_at')->nullable()->after('cancelled_at');
            }

            // Timestamp check-in (organizer tandai hadir)
            if (!Schema::hasColumn('event_registrations', 'checked_in_at')) {
                $table->timestamp('checked_in_at')->nullable()->after('payment_confirmed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('event_registrations', 'checked_in_at')) {
                $table->dropColumn('checked_in_at');
            }
            if (Schema::hasColumn('event_registrations', 'payment_confirmed_at')) {
                $table->dropColumn('payment_confirmed_at');
            }
            if (Schema::hasColumn('event_registrations', 'cancelled_at')) {
                $table->dropColumn('cancelled_at');
            }
        });
    }
};
