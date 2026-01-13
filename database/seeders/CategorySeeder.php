<?php

namespace Database\Seeders;

use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'key' => 'electrical_services',
                'name_en' => 'Electrical Services',
                'name_bg' => 'Електро услуги',
                'description_en' => 'Professional electrical installation and repair services',
                'description_bg' => 'Професионални услуги за електромонтаж и ремонт',
            ],
            [
                'key' => 'plumbing_services',
                'name_en' => 'Plumbing Services',
                'name_bg' => 'ВиК услуги',
                'description_en' => 'Water supply and sewage system installation and repair',
                'description_bg' => 'Монтаж и ремонт на водоснабдяване и канализация',
            ],
            [
                'key' => 'plastering_services',
                'name_en' => 'Plastering & Finishing',
                'name_bg' => 'Замазки и шпакловки',
                'description_en' => 'Professional wall plastering and finishing work',
                'description_bg' => 'Професионални услуги за замазки и шпакловки на стени',
            ],
            [
                'key' => 'painting_services',
                'name_en' => 'Painting Services',
                'name_bg' => 'Бояджийски услуги',
                'description_en' => 'Interior and exterior painting services',
                'description_bg' => 'Вътрешно и външно боядисване',
            ],
            [
                'key' => 'flooring_services',
                'name_en' => 'Flooring Services',
                'name_bg' => 'Подови настилки',
                'description_en' => 'Installation of tiles, parquet, and other flooring',
                'description_bg' => 'Монтаж на плочки, паркет и други подови покрития',
            ],
            [
                'key' => 'hvac_services',
                'name_en' => 'HVAC Services',
                'name_bg' => 'Отопление и климатизация',
                'description_en' => 'Heating, ventilation and air conditioning services',
                'description_bg' => 'Услуги за отопление, вентилация и климатизация',
            ],
        ];

        foreach ($categories as $data) {
            $category = Category::create([
                'translation_group' => 'categories' . '_' . $data['key'],
                'translation_key' => $data['key'],
            ]);

            // Create translations
            LanguageLine::create([
                'group' => $category->translation_group,
                'key' => "{$data['key']}.name",
                'text' => [
                    'en' => $data['name_en'],
                    'bg' => $data['name_bg'],
                ],
            ]);

            LanguageLine::create([
                'group' => $category->translation_group,
                'key' => "{$data['key']}.description",
                'text' => [
                    'en' => $data['description_en'],
                    'bg' => $data['description_bg'],
                ],
            ]);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
