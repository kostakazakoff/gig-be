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

        $authKey = "aa05992c-33fd-4094-9b0b-a367bf248aeb:fx";
        $deeplClient = new DeepLClient($authKey);

        $translatedText = $deeplClient->translateText($text, null, 'en-US');

        return response()->json([
            'translatedText' => $translatedText
        ]);
    }
}
