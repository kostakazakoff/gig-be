<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\TranslationLoader\LanguageLine;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['category_id', 'translation_group', 'translation_key', 'price_from', 'price_to', 'unit_id'];

    protected $appends = ['name', 'description', 'image_src'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('service_thumbs')
            ->useFallbackUrl('/GIG_960x480.jpg')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function getImageSrcAttribute(): ?string
    {
        $media = $this->getFirstMedia('service_thumbs');
        return $media ? $media->getUrl() : null;
    }

    public function getNameAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.name"
        );
    }

    public function getDescriptionAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.description"
        );
    }

    /**
     * Get translation for a specific language
     */
    public function getTranslation(string $key, string $locale = 'en'): ?string
    {
        $line = LanguageLine::where([
            'group' => $this->translation_group,
            'key' => "{$this->translation_key}.{$key}",
        ])->first();

        if (!$line) {
            return null;
        }

        return $line->text[$locale] ?? null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Units::class, 'unit_id');
    }
}
