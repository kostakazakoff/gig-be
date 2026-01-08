<?php

namespace Database\Seeders;

use App\Models\News;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsArticles = [
            [
                'key' => 'sustainable_building_practices',
                'title_en' => 'Sustainable Building Practices in 2025',
                'title_bg' => 'Устойчиво строителство през 2025',
                'content_en' => 'Discover the latest sustainable building techniques and materials that reduce environmental impact. Our company is committed to eco-friendly construction practices.',
                'content_bg' => 'Откройте най-новите техники за устойчиво строителство и материали, които намаляват екологичното въздействие. Нашата компания е ангажирана с приятелски към средата практики.',
            ],
            [
                'key' => 'smart_home_integration',
                'title_en' => 'Smart Home Technology Integration',
                'title_bg' => 'Интеграция на интелигентна домашна технология',
                'content_en' => 'Learn how modern smart home systems can be integrated into new construction projects. Enhance comfort and security with advanced automation solutions.',
                'content_bg' => 'Научете как съвременните интелигентни домашни системи могат да бъдат интегрирани в нови строителни проекти. Повишете комфорта и сигурността със специализирани решения.',
            ],
            [
                'key' => 'new_construction_standards',
                'title_en' => 'New EU Construction Standards 2025',
                'title_bg' => 'Нови стандарти за строителство на ЕС 2025',
                'content_en' => 'Updates on the latest EU construction regulations and safety standards. Our team stays current with all compliance requirements for your projects.',
                'content_bg' => 'Актуализации относно най-новите норми за строителство на ЕС и стандарти за безопасност. Нашия екип е в крак със всички изисквания за съответствие.',
            ],
            [
                'key' => 'energy_efficient_buildings',
                'title_en' => 'Energy-Efficient Building Solutions',
                'title_bg' => 'Енергийно ефективни решения за сгради',
                'content_en' => 'Explore energy-efficient insulation, HVAC systems, and renewable energy options. Save on operational costs while protecting the environment.',
                'content_bg' => 'Изследвайте енергийно ефективна изолация, HVAC системи и възобновяеми енергийни опции. Намалете оперативните разходи, като защитавате околната среда.',
            ],
            [
                'key' => 'project_completed_successfully',
                'title_en' => 'Major Residential Complex Completed Ahead of Schedule',
                'title_bg' => 'Голям жилищен комплекс завършен по-рано от предвиденото',
                'content_en' => 'We are proud to announce the successful completion of our latest residential complex project. The 120-unit development was delivered 2 months ahead of schedule with zero safety incidents.',
                'content_bg' => 'Горди сме да съобщим успешното завършване на нашия последния жилищен проект. 120-апартаментното развитие беше доставено 2 месеца по-рано със нулеви инциденти със сигурност.',
            ],
        ];

        foreach ($newsArticles as $data) {
            $news = News::create([
                'translation_group' => 'news' . '_' . $data['key'],
                'translation_key' => $data['key'],
            ]);

            // Create translations
            LanguageLine::create([
                'group' => $news->translation_group,
                'key' => "{$data['key']}.title",
                'text' => [
                    'en' => $data['title_en'],
                    'bg' => $data['title_bg'],
                ],
            ]);

            LanguageLine::create([
                'group' => $news->translation_group,
                'key' => "{$data['key']}.content",
                'text' => [
                    'en' => $data['content_en'],
                    'bg' => $data['content_bg'],
                ],
            ]);
        }

        $this->command->info('News articles seeded successfully!');
    }
}
