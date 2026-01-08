<?php

namespace Database\Seeders;

use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'key' => 'square_meter',
                'name_en' => 'Square Meter',
                'name_bg' => 'Кв. метър',
            ],
            [
                'key' => 'days',
                'name_en' => 'Days',
                'name_bg' => 'Дни',
            ],
            [
                'key' => 'project',
                'name_en' => 'Project',
                'name_bg' => 'Проект',
            ],
            [
                'key' => 'hours',
                'name_en' => 'Hours',
                'name_bg' => 'Часа',
            ],
            [
                'key' => 'linear_meter',
                'name_en' => 'Linear Meter',
                'name_bg' => 'Линеен метър',
            ],
        ];

        foreach ($units as $data) {
            $unit = Units::create([
                'translation_group' => 'units' . '_' . $data['key'],
                'translation_key' => $data['key'],
            ]);

            // Create translations
            LanguageLine::create([
                'group' => $unit->translation_group,
                'key' => "{$data['key']}.name",
                'text' => [
                    'en' => $data['name_en'],
                    'bg' => $data['name_bg'],
                ],
            ]);
        }

        $this->command->info('Units seeded successfully!');
    }
}
