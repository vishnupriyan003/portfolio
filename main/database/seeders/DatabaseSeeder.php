<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for local or laptop setup.
     */
    public function run(): void
    {
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
