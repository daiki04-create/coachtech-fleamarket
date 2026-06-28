<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('item_category')->truncate();
        DB::table('items')->truncate();

        $items = [
            ['name' => '腕時計', 'price' => 15000, 'brand' => 'Rolax', 'description' => 'スタイリッシュなデザイン', 'img_url' => 'Armani+Mens+Clock.jpg', 'condition' => '良好'],
            ['name' => 'HDD', 'price' => 5000, 'brand' => '西芝', 'description' => '信頼性の高いHDD', 'img_url' => 'HDD+Hard+Disk.jpg', 'condition' => '目立った傷や汚れなし'],
            ['name' => '玉ねぎ3束', 'price' => 300, 'brand' => 'なし', 'description' => '新鮮な玉ねぎ', 'img_url' => 'iLoveIMG+d.jpg', 'condition' => 'やや傷や汚れあり'],
            ['name' => '革靴', 'price' => 4000, 'brand' => 'なし', 'description' => 'クラシックな革靴', 'img_url' => 'Leather+Shoes+Product+Photo.jpg', 'condition' => '状態が悪い'],
            ['name' => 'ノートPC', 'price' => 45000, 'brand' => 'なし', 'description' => '高性能PC', 'img_url' => 'Living+Room+Laptop.jpg', 'condition' => '良好'],
            ['name' => 'マイク', 'price' => 8000, 'brand' => 'なし', 'description' => 'レコーディング用マイク', 'img_url' => 'Music+Mic+4632231.jpg', 'condition' => '目立った傷や汚れなし'],
            ['name' => 'ショルダーバッグ', 'price' => 3500, 'brand' => 'なし', 'description' => 'おしゃれなバッグ', 'img_url' => 'Purse+fashion+pocket.jpg', 'condition' => 'やや傷や汚れあり'],
            ['name' => 'タンブラー', 'price' => 500, 'brand' => 'なし', 'description' => '使いやすいタンブラー', 'img_url' => 'Tumbler+souvenir.jpg', 'condition' => '状態が悪い'],
            ['name' => 'コーヒーミル', 'price' => 4000, 'brand' => 'Starbacks', 'description' => '手動のミル', 'img_url' => 'Waitress+with+Coffee+Grinder.jpg', 'condition' => '良好'],
            ['name' => 'メイクセット', 'price' => 2500, 'brand' => 'なし', 'description' => '便利なメイクセット', 'img_url' => 'makeup.jpg', 'condition' => '目立った傷や汚れなし'],
        ];

        foreach ($items as $index => $itemData) {
            DB::table('items')->insert([
                'id' => $index + 1,
                'user_id' => 1,
                'name' => $itemData['name'],
                'price' => $itemData['price'],
                'brand' => $itemData['brand'],
                'description' => $itemData['description'],
                'img_url' => $itemData['img_url'],
                'condition' => $itemData['condition'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}