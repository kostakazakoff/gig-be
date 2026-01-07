<?php

namespace App\AppServices;

use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;

class DestroyUnit
{
    public function handle(Units $unit): void
    {
        $unit->delete();
    }
}
