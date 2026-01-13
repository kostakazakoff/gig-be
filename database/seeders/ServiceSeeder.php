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
        $electricalCategory = Category::where('translation_key', 'electrical_services')->first();
        $plumbingCategory = Category::where('translation_key', 'plumbing_services')->first();
        $plasteringCategory = Category::where('translation_key', 'plastering_services')->first();
        $paintingCategory = Category::where('translation_key', 'painting_services')->first();
        $flooringCategory = Category::where('translation_key', 'flooring_services')->first();
        $hvacCategory = Category::where('translation_key', 'hvac_services')->first();
        
        $sqmUnit = Units::where('translation_key', 'square_meter')->first();
        $daysUnit = Units::where('translation_key', 'days')->first();
        $projectUnit = Units::where('translation_key', 'project')->first();

        $services = [
            // Electrical Services
            [
                'key' => 'electrical_installation',
                'category_id' => $electricalCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Electrical Installation',
                'name_bg' => 'Електромонтаж',
                'description_en' => 'Complete electrical wiring and installation',
                'description_bg' => 'Пълен електромонтаж и инсталация',
                'price_from' => 800,
                'price_to' => 3000,
            ],
            [
                'key' => 'electrical_repair',
                'category_id' => $electricalCategory->id,
                'unit_id' => $daysUnit->id,
                'name_en' => 'Electrical Repair',
                'name_bg' => 'Ремонт на електрическа инсталация',
                'description_en' => 'Troubleshooting and repair of electrical systems',
                'description_bg' => 'Диагностика и ремонт на електрически системи',
                'price_from' => 50,
                'price_to' => 200,
            ],
            [
                'key' => 'socket_switch_installation',
                'category_id' => $electricalCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Socket & Switch Installation',
                'name_bg' => 'Монтаж на контакти и ключове',
                'description_en' => 'Installation of electrical sockets and switches',
                'description_bg' => 'Монтаж на електрически контакти и ключове',
                'price_from' => 15,
                'price_to' => 30,
            ],
            // Plumbing Services
            [
                'key' => 'plumbing_installation',
                'category_id' => $plumbingCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Plumbing Installation',
                'name_bg' => 'ВиК монтаж',
                'description_en' => 'Water supply and sewage system installation',
                'description_bg' => 'Монтаж на водоснабдяване и канализация',
                'price_from' => 1000,
                'price_to' => 4000,
            ],
            [
                'key' => 'pipe_repair',
                'category_id' => $plumbingCategory->id,
                'unit_id' => $daysUnit->id,
                'name_en' => 'Pipe Repair',
                'name_bg' => 'Ремонт на тръби',
                'description_en' => 'Emergency and scheduled pipe repair',
                'description_bg' => 'Аварийни и планови ремонти на тръби',
                'price_from' => 80,
                'price_to' => 300,
            ],
            [
                'key' => 'bathroom_fitting',
                'category_id' => $plumbingCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Bathroom Fitting',
                'name_bg' => 'Монтаж на баня',
                'description_en' => 'Complete bathroom plumbing and fitting',
                'description_bg' => 'Пълен монтаж на санитария в баня',
                'price_from' => 500,
                'price_to' => 2000,
            ],
            // Plastering Services
            [
                'key' => 'wall_plastering',
                'category_id' => $plasteringCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Wall Plastering',
                'name_bg' => 'Замазка на стени',
                'description_en' => 'Professional wall plastering service',
                'description_bg' => 'Професионална замазка на стени',
                'price_from' => 15,
                'price_to' => 30,
            ],
            [
                'key' => 'ceiling_plastering',
                'category_id' => $plasteringCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Ceiling Plastering',
                'name_bg' => 'Замазка на тавани',
                'description_en' => 'Ceiling plastering and finishing',
                'description_bg' => 'Замазка и изравняване на тавани',
                'price_from' => 18,
                'price_to' => 35,
            ],
            [
                'key' => 'gypsum_board_installation',
                'category_id' => $plasteringCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Gypsum Board Installation',
                'name_bg' => 'Монтаж на гипсокартон',
                'description_en' => 'Drywall and gypsum board installation',
                'description_bg' => 'Монтаж на гипсокартон и сухо строителство',
                'price_from' => 20,
                'price_to' => 40,
            ],
            // Painting Services
            [
                'key' => 'interior_painting',
                'category_id' => $paintingCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Interior Painting',
                'name_bg' => 'Вътрешно боядисване',
                'description_en' => 'Professional interior wall painting',
                'description_bg' => 'Професионално боядисване на вътрешни стени',
                'price_from' => 8,
                'price_to' => 20,
            ],
            [
                'key' => 'exterior_painting',
                'category_id' => $paintingCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Exterior Painting',
                'name_bg' => 'Външно боядисване',
                'description_en' => 'Exterior facade painting and finishing',
                'description_bg' => 'Външно боядисване на фасади',
                'price_from' => 12,
                'price_to' => 25,
            ],
            // Flooring Services
            [
                'key' => 'tile_installation',
                'category_id' => $flooringCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Tile Installation',
                'name_bg' => 'Полагане на плочки',
                'description_en' => 'Professional floor and wall tile installation',
                'description_bg' => 'Професионално полагане на плочки за под и стени',
                'price_from' => 25,
                'price_to' => 50,
            ],
            [
                'key' => 'parquet_installation',
                'category_id' => $flooringCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Parquet Installation',
                'name_bg' => 'Монтаж на паркет',
                'description_en' => 'Hardwood and laminate flooring installation',
                'description_bg' => 'Монтаж на паркет и ламинат',
                'price_from' => 20,
                'price_to' => 45,
            ],
            [
                'key' => 'screed_floor',
                'category_id' => $flooringCategory->id,
                'unit_id' => $sqmUnit->id,
                'name_en' => 'Floor Screed',
                'name_bg' => 'Циментова замазка',
                'description_en' => 'Concrete floor screed and leveling',
                'description_bg' => 'Циментова замазка и изравняване на подове',
                'price_from' => 15,
                'price_to' => 30,
            ],
            // HVAC Services
            [
                'key' => 'ac_installation',
                'category_id' => $hvacCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Air Conditioning Installation',
                'name_bg' => 'Монтаж на климатик',
                'description_en' => 'Air conditioning unit installation and setup',
                'description_bg' => 'Монтаж и настройка на климатична система',
                'price_from' => 300,
                'price_to' => 800,
            ],
            [
                'key' => 'heating_system',
                'category_id' => $hvacCategory->id,
                'unit_id' => $projectUnit->id,
                'name_en' => 'Heating System Installation',
                'name_bg' => 'Монтаж на отоплителна система',
                'description_en' => 'Central heating and radiator installation',
                'description_bg' => 'Монтаж на централно отопление и радиатори',
                'price_from' => 1500,
                'price_to' => 5000,
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
