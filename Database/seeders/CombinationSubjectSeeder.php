<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CombinationSubjectSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local','development'])) {
            $this->command->warn('CombinationSubjectSeeder skipped: not running in production.');
            return;
        }

        $companies = DB::table('companies')->where('school_type','secondary')->get();

        foreach ($companies as $company) {
            $combinations = DB::table('combinations')->where('company_id',$company->id)->get();

            foreach ($combinations as $combo) {
                // Example: PCM = Physics, Chemistry, Mathematics
                $subjectNames = explode(', ', $combo->description);

                foreach ($subjectNames as $name) {
                    $subjectId = DB::table('subjects')
                        ->where('company_id',$company->id)
                        ->where('name',$name)
                        ->value('id');

                    if ($subjectId) {
                        DB::table('combination_subject')->updateOrInsert(
                            [
                                'combination_id' => $combo->id,
                                'subject_id'     => $subjectId,
                                'company_id'     => $company->id,
                            ],
                            [
                                'uuid'       => Str::uuid(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]
                        );
                    }
                }
            }
        }
    }
}
