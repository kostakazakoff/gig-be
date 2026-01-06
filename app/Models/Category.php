<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['translation_group', 'translation_key'];

    protected $appends = ['name', 'description'];

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
}
