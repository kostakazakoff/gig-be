<?php

namespace App\Http\Controllers;

use DeepL\DeepLClient;
use Illuminate\Http\Request;
use DeepL\Translator;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $text = $request->input('text');

        $authKey = env('DEEPL_API_KEY');
        $deeplClient = new DeepLClient(
            $authKey,
            ['base_uri' => env('DEEPL_URI'),]
        );

        $translatedText = $deeplClient->translateText($text, null, 'en-US');

        return response()->json([
            'translatedText' => $translatedText->text,
        ]);
    }
}
