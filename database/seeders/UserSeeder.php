<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'tally',
                'password' => '$2y$12$7lVS2WOdWe9RZ8dxA5PY.OSYDVknTEm8CoOoqT0qjhl.UBKCDLK.u',
                'role' => 'tally',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'username' => 'gateout',
                'password' => '$2y$12$7lVS2WOdWe9RZ8dxA5PY.OSYDVknTEm8CoOoqT0qjhl.UBKCDLK.u',
                'role' => 'gateout',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Reset PostgreSQL auto-increment sequence
        if (config('database.default') === 'pgsql') {
            $maxId = DB::table('users')->max('id');
            if ($maxId) {
                DB::statement("SELECT setval('users_id_seq', ?)", [$maxId]);
            }
        }
    }
}
