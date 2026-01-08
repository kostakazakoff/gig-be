<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Category;
use App\Models\Service;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $services = Service::all();

        $projects = [
            [
                'key' => 'residential_complex_sofia',
                'title_en' => 'Modern Residential Complex in Sofia',
                'title_bg' => 'Съвременен жилищен комплекс в София',
                'description_en' => 'Construction of a 120-unit residential complex with modern amenities and green spaces',
                'description_bg' => '120-апартаментен жилищен комплекс със съвременни удобства и зелени площи',
                'price' => 2500000,
                'date' => '2025-12-15',
            ],
            [
                'key' => 'office_building_renovation',
                'title_en' => 'Downtown Office Building Renovation',
                'title_bg' => 'Реновация на офис сграда в центъра',
                'description_en' => 'Complete interior renovation and modernization of 5-story office building',
                'description_bg' => 'Пълна вътрешна реновация на 5-етажна офис сграда',
                'price' => 850000,
                'date' => '2025-11-20',
            ],
            [
                'key' => 'commercial_mall_expansion',
                'title_en' => 'Shopping Mall Expansion Project',
                'title_bg' => 'Разширение на търговски център',
                'description_en' => 'Expansion of existing shopping mall with new retail spaces and dining area',
                'description_bg' => 'Разширение на съществуващ търговски център с нови магазини и хранилище',
                'price' => 3200000,
                'date' => '2025-10-10',
            ],
            [
                'key' => 'infrastructure_highway',
                'title_en' => 'Highway Infrastructure Development',
                'title_bg' => 'Развитие на магистралната инфраструктура',
                'description_en' => '45km highway construction with modern drainage and safety systems',
                'description_bg' => '45км магистрала с модерни дренажни и безопасностни системи',
                'price' => 5500000,
                'date' => '2025-09-30',
            ],
            [
                'key' => 'villa_construction_seaside',
                'title_en' => 'Luxury Villa Construction - Seaside',
                'title_bg' => 'Строителство на луксозна вила край морето',
                'description_en' => 'Construction of a 500 sqm luxury villa with premium finishes',
                'description_bg' => 'Строителство на 500 кв.м луксозна вила със премиум покривки',
                'price' => 450000,
                'date' => '2025-08-15',
            ],
        ];

        foreach ($projects as $data) {
            $project = Project::create([
                'translation_group' => 'projects' . '_' . $data['key'],
                'translation_key' => $data['key'],
                'price' => $data['price'],
                'date' => $data['date'],
            ]);

            // Create translations
            LanguageLine::create([
                'group' => $project->translation_group,
                'key' => "{$data['key']}.title",
                'text' => [
                    'en' => $data['title_en'],
                    'bg' => $data['title_bg'],
                ],
            ]);

            LanguageLine::create([
                'group' => $project->translation_group,
                'key' => "{$data['key']}.description",
                'text' => [
                    'en' => $data['description_en'],
                    'bg' => $data['description_bg'],
                ],
            ]);
        }

        $this->command->info('Projects seeded successfully!');
    }
}
