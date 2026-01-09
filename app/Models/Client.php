<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'company',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_thumbs')
            ->acceptsMimeTypes(['image/jpeg',  'image/jpg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
