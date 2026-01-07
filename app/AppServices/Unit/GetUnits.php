<?php

namespace App\AppServices\Unit;

use App\Models\Units;

class GetUnits
{
    public function handle()
    {
        return Units::orderBy('translation_key')->get();
    }
}
