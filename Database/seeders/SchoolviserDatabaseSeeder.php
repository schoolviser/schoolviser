<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolviserDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CompanySchoolTypeSeeder::class,
            AcademicYearSeeder::class,
            TermSeeder::class,
            ClazzSeeder::class,
            CourseSeeder::class,
            TertiaryStudentSeeder::class,
            StudentSeeder::class,
        ]);
    }

}
