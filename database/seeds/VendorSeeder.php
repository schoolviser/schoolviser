<?php

use Illuminate\Database\Seeder;

use App\Models\Vendor\Vendor;
use App\Models\Vendor\VendorContactPerson;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendor = vendor::create([
            'name' => 'Delgont Technologies Ltd',
            'address' => 'Pallisa, Uganda',
            'phone' => '+25674285504',
            'first_name' => 'Okello',
            'last_name' => 'Stephen'
        ]);

        VendorContactPerson::create([
            'name' => 'Stephen Okello Omoding',
            'address' => 'Pallisa Uganda',
            'phone' => '+25674285504',
            'position' => 'CEO',
            'vendor_id' => $vendor->id
        ]);


    }
}
