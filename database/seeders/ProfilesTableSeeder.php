<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('profiles')->truncate();

        DB::table('profiles')->insert([
            [
                'user_id' => 1,
                'img_url' => 'https://example.com/avatar/taro.jpg',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1',
                'building' => '千代田ビル301',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'img_url' => null,
                'postal_code' => '530-0001',
                'address' => '大阪府大阪市北区梅田1-1',
                'building' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}