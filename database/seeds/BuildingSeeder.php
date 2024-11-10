<?php

use Illuminate\Database\Seeder;

use App\Models\Building;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildings = [
            'Administration Block' => [
                'Bursars Office',
                'Finance & Admin Office',
                'Staff Room',
                'Reception',
                'Directors Office',
                'Deputy Headteacher Office',
                'Wadens Office'
            ]
            ];

        foreach($buildings as $key => $value) {
            # code...
            $building = Building::updateOrCreate([
                'name' => $key
            ]);

            foreach ($value as $room) {
                # code...
                $building->rooms()->updateOrCreate([
                    'name' => $room
                ]);
            }
        }
    }
}
