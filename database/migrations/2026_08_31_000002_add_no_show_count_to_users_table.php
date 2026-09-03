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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'no_show_count')) {
                $table->unsignedInteger('no_show_count')->default(0)->after('status');
            }

            if (!Schema::hasColumn('users', 'is_restricted')) {
                $table->boolean('is_restricted')->default(false)->after('no_show_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_restricted')) {
                $table->dropColumn('is_restricted');
            }
            if (Schema::hasColumn('users', 'no_show_count')) {
                $table->dropColumn('no_show_count');
            }
        });
    }
};
