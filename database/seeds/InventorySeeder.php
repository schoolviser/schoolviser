<?php

use Illuminate\Database\Seeder;

use App\Models\Inventory\InventoryItem;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new InventoryItem;
        $product->name = 'Posho';
        $product->save();
    }
}
