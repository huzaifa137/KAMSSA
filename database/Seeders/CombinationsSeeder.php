<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CombinationsSeeder extends Seeder
{
    // php artisan db:seed --class=CombinationsSeeder
    //
    // Requires UceUaceSubjectsSeeder to have already been run, since each
    // combination below is defined in terms of the UACE subject codes it
    // creates (PHY, CHEM, BIO, MATH, ECON, GEOG, HIST, DIV, LIT, AGRIC, CS).
    public function run(): void
    {
        $uaceCode = config('constants.options.UACEPapers', 25);

        // Common Uganda UACE combinations. Subject codes here refer to the
        // 'code' values seeded in UceUaceSubjectsSeeder's $uace list.
        $combinations = [
            ['code' => 'PCM', 'name' => 'Physics, Chemistry, Mathematics', 'subjects' => ['PHY', 'CHEM', 'MATH']],
            ['code' => 'PCB', 'name' => 'Physics, Chemistry, Biology', 'subjects' => ['PHY', 'CHEM', 'BIO']],
            ['code' => 'MEG', 'name' => 'Mathematics, Economics, Geography', 'subjects' => ['MATH', 'ECON', 'GEOG']],
            ['code' => 'HEG', 'name' => 'History, Economics, Geography', 'subjects' => ['HIST', 'ECON', 'GEOG']],
            ['code' => 'HED', 'name' => 'History, Economics, Divinity', 'subjects' => ['HIST', 'ECON', 'DIV']],
            ['code' => 'HGL', 'name' => 'History, Geography, Literature in English', 'subjects' => ['HIST', 'GEOG', 'LIT']],
            ['code' => 'MEC', 'name' => 'Mathematics, Economics, Computer Science', 'subjects' => ['MATH', 'ECON', 'CS']],
            ['code' => 'BCA', 'name' => 'Biology, Chemistry, Agriculture', 'subjects' => ['BIO', 'CHEM', 'AGRIC']],
        ];

        $now = now();

        foreach ($combinations as $c) {
            $combinationId = DB::table('combinations')->where([
                'category' => 'UACE',
                'code' => $c['code'],
            ])->value('id');

            if ($combinationId) {
                DB::table('combinations')->where('id', $combinationId)->update([
                    'name' => $c['name'],
                    'status' => 'Active',
                    'updated_at' => $now,
                ]);
            } else {
                $combinationId = DB::table('combinations')->insertGetId([
                    'category' => 'UACE',
                    'code' => $c['code'],
                    'name' => $c['name'],
                    'status' => 'Active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $subjectIds = DB::table('master_datas')
                ->where('md_master_code_id', $uaceCode)
                ->whereIn('md_code', $c['subjects'])
                ->pluck('md_id');

            if ($subjectIds->count() !== count($c['subjects'])) {
                $found = DB::table('master_datas')
                    ->where('md_master_code_id', $uaceCode)
                    ->whereIn('md_code', $c['subjects'])
                    ->pluck('md_code')
                    ->all();
                $missing = array_diff($c['subjects'], $found);
                $this->command?->warn(
                    "Combination {$c['code']}: could not find subject code(s) [" . implode(', ', $missing) . "] "
                    . "under UACE — run UceUaceSubjectsSeeder first, or check the codes match."
                );
            }

            foreach ($subjectIds as $subjectId) {
                DB::table('combination_subjects')->updateOrInsert(
                    ['combination_id' => $combinationId, 'subject_id' => $subjectId],
                    ['created_at' => $now, 'updated_at' => $now]
                );
            }
        }
    }
}