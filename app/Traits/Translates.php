<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

trait Translates
{
    public function translate(Model $model, array $data, array $attributes)
    {
        foreach ($attributes as $attribute) {
            LanguageLine::create([
                'group' => $model->translation_group,
                'key' => "{$data['key']}.".$attribute,
                'text' => [
                    'en' => $data["{$attribute}"."_en"],
                    'bg' => $data["{$attribute}"."_bg"],
                ],
            ]);

            cache()->forget('spatie.translation-loader');
        }
    }
}