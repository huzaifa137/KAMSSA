<?php

namespace Database\Seeders;

use App\Models\ExaminationCategory;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemConfigurationSeeder extends Seeder
{
    /**
     * Seeds the system with its current, existing setup so that turning
     * this module on does not change anything the client already sees.
     * When onboarding a NEW client, do not re-run this seeder - instead
     * use the "System Configuration" screens in the admin panel to
     * change these values (System Settings > General, and
     * System Settings > Examination Categories).
     */
    public function run(): void
    {
        SystemSetting::query()->firstOrCreate([], [
            'system_name' => 'Kampala Integrated Secondary Schools Examination',
            'short_name'  => 'Kamssa',
            'tagline'     => "Uganda's trusted secondary examination board for O-LEVEL and A-LEVEL",
            'address'     => 'Kampala, Uganda',
            'footer_text' => 'The official examination authority responsible for standardising, administering, and certifying results.',
        ]);

        $categories = [
            [
                'name' => 'Primary Mock Examination',
                'code' => 'PRIMARY_MOCK',
                'sort_order' => 1,
                'levels' => [
                    ['name' => 'Primary Leaving Examination', 'short_code' => 'PLE', 'sort_order' => 1],
                ],
            ],
            [
                'name' => 'Secondary Mock Examination',
                'code' => 'SECONDARY_MOCK',
                'sort_order' => 2,
                'levels' => [
                    ['name' => 'Uganda Certificate of Education',          'short_code' => 'UCE',  'sort_order' => 1],
                    ['name' => 'Uganda Advanced Certificate of Education', 'short_code' => 'UACE', 'sort_order' => 2],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $levels = $categoryData['levels'];
            unset($categoryData['levels']);

            $category = ExaminationCategory::firstOrCreate(
                ['code' => $categoryData['code']],
                $categoryData
            );

            foreach ($levels as $level) {
                $category->levels()->firstOrCreate(
                    ['short_code' => $level['short_code']],
                    $level
                );
            }
        }
    }
}
