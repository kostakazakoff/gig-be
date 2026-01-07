<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    use HttpResponses;
    public function switch(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:bg,en',
        ]);

        app()->setLocale($request->locale);

        return $this->success(['locale' => $request->locale])
            ->cookie('locale', $request->locale, 60 * 24 * 365); // 1 year
    }

    public function getLocale(Request $request)
    {
        $locale = session('locale', config('app.locale'));

        return $this->success(['locale' => $locale]);
    }
}
