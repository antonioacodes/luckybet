<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class FacebookPixelComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Busca o token (primeiro registro da tabela)
        $pixelId = Setting::value('fb_pixel_token');

        // Caso a tabela seja key/value:
        // $pixelId = Setting::where('key', 'fb_pixel_token')->value('value');

        $view->with('pixelId', $pixelId);
    }
}
