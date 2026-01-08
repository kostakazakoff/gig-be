<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residentialCategory = Category::where('translation_key', 'residential_construction')->first();
        $commercialCategory = Category::where('translation_key', 'commercial_construction')->first();
        $renovationCategory = Category::where('translation_key', 'renovation_repair')->first();
        
        $sqmUnit = Units::where('translation_key', 'square_meter')->first();
        $daysUnit = Units::where('translation_key', 'days')->first();
        $projectUnit = Units::where('translation_key', 'project')->first();

        $services = [
            [
                'key' => 'foundation_construction',
                'category_id' => $residentialCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Foundation Construction',
                'name_bg' => 'Construccia на основа',
                'description_en' => 'Professional foundation work for residential buildings',
                'description_bg' => 'Професионални работи за основата на жилищни сгради',
                'price_from' => 80,
                'price_to' => 150,
            ],
            [
                'key' => 'wall_construction',
                'category_id' => $residentialCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Wall Construction',
                'name_bg' => 'Konstrukcia на стени',
                'description_en' => 'Quality wall building and masonry work',
                'description_bg' => 'Качествена конструкция и камендария работа',
                'price_from' => 50,
                'price_to' => 120,
            ],
            [
                'key' => 'roof_installation',
                'category_id' => $residentialCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Roof Installation',
                'name_bg' => 'Монтаж на покрив',
                'description_en' => 'Modern roofing solutions and installation',
                'description_bg' => 'Съвременни кровельни решения и монтаж',
                'price_from' => 60,
                'price_to' => 140,
            ],
            [
                'key' => 'interior_finishing',
                'category_id' => $renovationCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Interior Finishing',
                'name_bg' => 'Вътрешно завършване',
                'description_en' => 'Professional interior renovation and finishing',
                'description_bg' => 'Професионална вътрешна реновация и завършване',
                'price_from' => 40,
                'price_to' => 100,
            ],
            [
                'key' => 'electrical_plumbing',
                'category_id' => $residentialCategory->id,
                'unit_id' => $daysUnit->id,
                'name_en' => 'Electrical & Plumbing',
                'name_bg' => 'Електричество и водопровод',
                'description_en' => 'Installation of electrical systems and plumbing',
                'description_bg' => 'Монтаж на електрически системи и водопровод',
                'price_from' => 500,
                'price_to' => 2000,
            ],
            [
                'key' => 'commercial_fit_out',
                'category_id' => $commercialCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Commercial Fit-out',
                'name_bg' => 'Търговско оборудване',
                'description_en' => 'Complete fit-out services for commercial spaces',
                'description_bg' => 'Пълни услуги за оборудване на търговски пространства',
                'price_from' => 5000,
                'price_to' => 50000,
            ],
        ];

        foreach ($services as $data) {
            $service = Service::create([
                'category_id' => $data['category_id'],
                'unit_id' => $data['unit_id'],
                'translation_group' => 'services' . '_' . $data['key'],
                'translation_key' => $data['key'],
                'price_from' => $data['price_from'],
                'price_to' => $data['price_to'],
            ]);

            // Create translations
            LanguageLine::create([
                'group' => $service->translation_group,
                'key' => "{$data['key']}.name",
                'text' => [
                    'en' => $data['name_en'],
                    'bg' => $data['name_bg'],
                ],
            ]);

            LanguageLine::create([
                'group' => $service->translation_group,
                'key' => "{$data['key']}.description",
                'text' => [
                    'en' => $data['description_en'],
                    'bg' => $data['description_bg'],
                ],
            ]);
        }

        $this->command->info('Services seeded successfully!');
    }
}
