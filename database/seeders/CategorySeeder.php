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
                'key' => 'residential_construction',
                'name_en' => 'Residential Construction',
                'name_bg' => 'Жилищно строителство',
                'description_en' => 'Professional residential building and renovation services',
                'description_bg' => 'Професионални услуги за жилищно строителство и реновация',
            ],
            [
                'key' => 'commercial_construction',
                'name_en' => 'Commercial Construction',
                'name_bg' => 'Търговско строителство',
                'description_en' => 'Commercial and office building construction projects',
                'description_bg' => 'Търговски и офис строителни проекти',
            ],
            [
                'key' => 'renovation_repair',
                'name_en' => 'Renovation & Repair',
                'name_bg' => 'Реновация и ремонт',
                'description_en' => 'Expert renovation and maintenance services',
                'description_bg' => 'Експертни услуги за реновация и поддръжка',
            ],
            [
                'key' => 'infrastructure',
                'name_en' => 'Infrastructure',
                'name_bg' => 'Инфраструктура',
                'description_en' => 'Road, bridge and utility infrastructure projects',
                'description_bg' => 'Проекти за пътища, мостове и комунална инфраструктура',
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
