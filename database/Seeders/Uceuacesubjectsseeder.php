<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UceUaceSubjectsSeeder extends Seeder
{
    // php artisan db:seed --class=UceUaceSubjectsSeeder
    public function run(): void
    {
        $uceCode  = config('constants.options.UCEPapers', 24);
        $uaceCode = config('constants.options.UACEPapers', 25);

        // Uganda Certificate of Education (O-LEVEL) subjects.
        // 'Compulsory' subjects are auto-registered for every UCE student.
        // 'Optional' subjects are only registered when picked during import / manual registration.
        $uce = [
            ['code' => 'ENG', 'name' => 'English Language', 'status' => 'Compulsory'],
            ['code' => 'MATH', 'name' => 'Mathematics', 'status' => 'Compulsory'],
            ['code' => 'BIO', 'name' => 'Biology', 'status' => 'Optional'],
            ['code' => 'PHY', 'name' => 'Physics', 'status' => 'Optional'],
            ['code' => 'CHEM', 'name' => 'Chemistry', 'status' => 'Optional'],
            ['code' => 'HIST', 'name' => 'History', 'status' => 'Optional'],
            ['code' => 'GEOG', 'name' => 'Geography', 'status' => 'Optional'],
            ['code' => 'CRE', 'name' => 'Christian Religious Education', 'status' => 'Optional'],
            ['code' => 'IRE', 'name' => 'Islamic Religious Education', 'status' => 'Optional'],
            ['code' => 'AGRIC', 'name' => 'Agriculture', 'status' => 'Optional'],
            ['code' => 'COMM', 'name' => 'Commerce', 'status' => 'Optional'],
            ['code' => 'COMP', 'name' => 'Computer Studies', 'status' => 'Optional'],
            ['code' => 'FART', 'name' => 'Fine Art', 'status' => 'Optional'],
            ['code' => 'LIT', 'name' => 'Literature in English', 'status' => 'Optional'],
            ['code' => 'KISW', 'name' => 'Kiswahili', 'status' => 'Optional'],
            ['code' => 'LUG', 'name' => 'Luganda', 'status' => 'Optional'],
            ['code' => 'ARAB', 'name' => 'Arabic', 'status' => 'Optional'],
            ['code' => 'PE', 'name' => 'Physical Education', 'status' => 'Optional'],
            ['code' => 'ENT', 'name' => 'Entrepreneurship Education', 'status' => 'Optional'],
            ['code' => 'TD', 'name' => 'Technical Drawing', 'status' => 'Optional'],
            ['code' => 'HE', 'name' => 'Home Economics', 'status' => 'Optional'],
        ];

        // Uganda Advanced Certificate of Education (A-LEVEL) subjects.
        // General Paper is compulsory for every UACE student; the rest are
        // principal / subsidiary subjects picked per student's combination.
        $uace = [
            ['code' => 'GP', 'name' => 'General Paper', 'status' => 'Compulsory'],
            ['code' => 'PHY', 'name' => 'Physics', 'status' => 'Optional'],
            ['code' => 'CHEM', 'name' => 'Chemistry', 'status' => 'Optional'],
            ['code' => 'BIO', 'name' => 'Biology', 'status' => 'Optional'],
            ['code' => 'MATH', 'name' => 'Mathematics', 'status' => 'Optional'],
            ['code' => 'ECON', 'name' => 'Economics', 'status' => 'Optional'],
            ['code' => 'GEOG', 'name' => 'Geography', 'status' => 'Optional'],
            ['code' => 'HIST', 'name' => 'History', 'status' => 'Optional'],
            ['code' => 'DIV', 'name' => 'Divinity (CRE)', 'status' => 'Optional'],
            ['code' => 'IRE', 'name' => 'Islamic Religious Education', 'status' => 'Optional'],
            ['code' => 'LIT', 'name' => 'Literature in English', 'status' => 'Optional'],
            ['code' => 'KISW', 'name' => 'Kiswahili', 'status' => 'Optional'],
            ['code' => 'FART', 'name' => 'Fine Art', 'status' => 'Optional'],
            ['code' => 'AGRIC', 'name' => 'Agriculture', 'status' => 'Optional'],
            ['code' => 'CS', 'name' => 'Computer Science', 'status' => 'Optional'],
            ['code' => 'ENT', 'name' => 'Entrepreneurship', 'status' => 'Optional'],
            ['code' => 'SMATH', 'name' => 'Subsidiary Mathematics', 'status' => 'Optional'],
            ['code' => 'SICT', 'name' => 'Subsidiary ICT', 'status' => 'Optional'],
        ];

        $now = now();

        // updateOrInsert (not delete+insert) so md_id stays stable across
        // re-runs — important once real marks/registrations start
        // referencing these subject ids as foreign keys.
        foreach ($uce as $s) {
            $this->upsertSubject($uceCode, $s, $now);
        }
        foreach ($uace as $s) {
            $this->upsertSubject($uaceCode, $s, $now);
        }
    }

    private function upsertSubject(int $masterCodeId, array $s, $now): void
    {
        DB::table('master_datas')->updateOrInsert(
            ['md_master_code_id' => $masterCodeId, 'md_code' => $s['code']],
            [
                'md_name' => $s['name'],
                'md_description' => $s['status'] . ' subject',
                'md_date_added' => $now->toDateString(),
                'md_added_by' => 'system',
                'md_misc1' => $s['status'], // 'Compulsory' or 'Optional'
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }
}