<?php

namespace Modules\Schoolviser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CombinationSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local','development'])) {
            $this->command->warn('CombinationSeeder skipped: not running in production.');
            return;
        }

        $companies = DB::table('companies')->where('school_type','secondary')->get();

        // Example combinations
        $combinations = [
            ['name' => 'PCM', 'subjects' => ['Physics','Chemistry','Mathematics'], 'subsidiaries' => ['General Paper','Subsidiary Mathematics']],
            ['name' => 'PCB', 'subjects' => ['Physics','Chemistry','Biology'], 'subsidiaries' => ['General Paper','Subsidiary Mathematics']],
            ['name' => 'MEG', 'subjects' => ['Mathematics','Economics','Geography'], 'subsidiaries' => ['General Paper']],
            ['name' => 'HEG', 'subjects' => ['History','Economics','Geography'], 'subsidiaries' => ['General Paper']],
        ];

        foreach ($companies as $company) {
            foreach ($combinations as $combo) {
                $comboId = DB::table('combinations')->insertGetId([
                    'uuid' => Str::uuid(),
                    'name' => $combo['name'],
                    'description' => implode(', ', $combo['subjects']),
                    'company_id' => $company->id,
                    'subsidiary1_id' => DB::table('subjects')->where('company_id',$company->id)->where('name',$combo['subsidiaries'][0])->value('id'),
                    'subsidiary2_id' => isset($combo['subsidiaries'][1]) ? DB::table('subjects')->where('company_id',$company->id)->where('name',$combo['subsidiaries'][1])->value('id') : null,
                    'subsidiary3_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($combo['subjects'] as $subjectName) {
                    $subjectId = DB::table('subjects')->where('company_id',$company->id)->where('name',$subjectName)->value('id');
                    if ($subjectId) {
                        DB::table('combination_subjects')->insert([
                            'combination_id' => $comboId,
                            'subject_id' => $subjectId,
                            'company_id' => $company->id
                        ]);
                    }
                }
            }
        }
    }
}
