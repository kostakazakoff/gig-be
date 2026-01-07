<?php

namespace App\AppServices;

use App\Models\Units;

class IndexUnits
{
    public function handle()
    {
        return Units::with('services')->latest()->get();
    }
}
