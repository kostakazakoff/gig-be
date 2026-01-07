<?php

namespace App\AppServices\Unit;

use App\Models\Units;

class IndexUnits
{
    public function handle()
    {
        return Units::with('services')->latest()->get();
    }
}
