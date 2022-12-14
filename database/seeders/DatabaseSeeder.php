<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Customer;
use  App\Models\Purchase;
use  App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
            RankSeeder::class,
        ]);

        Customer::factory(1000)->create();

        $items = Item::all();

        Purchase::factory(10000)->create()
        ->each(function(Purchase $purchase) use ($items){
            $purchase->items()->attach(
            $items->random(rand(1,3))->pluck('id')->toArray(),
            // 1～3個のitemをpurchaseにランダムに紐づけ
            // pluckで特定カラム抽出後（collection）、配列に変換
            ['quantity' => rand(1, 5) ] );
        });
    }
}
