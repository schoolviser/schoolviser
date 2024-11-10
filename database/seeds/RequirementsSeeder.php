<?php

use Illuminate\Database\Seeder;

use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementItem;




class RequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = RequirementItem::updateOrCreate(['name' => 'Toilet Paper']);

        Requirement::create([
            'quantity' => 3,
            'new_or_continuing' => 'continuing',
            'requirement_item_id' => $item->id,
            'term_id' => term()->id,
            'clazz_id' => 1
        ]);
    }
}
