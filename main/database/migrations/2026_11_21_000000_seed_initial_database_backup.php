<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Seeds initial production settings so a fresh checkout on any laptop/server
     * has full working state immediately upon `php artisan migrate`.
     */
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')->updateOrInsert(
                ['key' => 'portfolio_views'],
                [
                    'value' => '79',
                    'created_at' => '2026-05-10 15:00:04',
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')->where('key', 'portfolio_views')->delete();
        }
    }
};
