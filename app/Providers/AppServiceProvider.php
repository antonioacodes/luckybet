<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Filament\Support\Assets\Js;
use App\Http\View\Composers\FacebookPixelComposer;
use Illuminate\Support\Facades\View;   // <‑‑ IMPORTANTE

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // aqui você pode registrar bindings, singletons, etc.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Se quiser registrar assets do Filament, descomente:
        // FilamentAsset::register([
        //     Js::make('filament-tools', base_path('vendor/sebastiaankloos/filament-code-editor/dist/filament-tools.js')),
        // ]);

        // -------------------------------------------------
        //  View Composer – injeta o Pixel ID em todas as views
        // -------------------------------------------------
        View::composer('*', FacebookPixelComposer::class);

        // -------------------------------------------------
        //  Outras configurações que você já tinha
        // -------------------------------------------------
        Schema::defaultStringLength(191);

        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $buffer = explode('.', $attribute);
                            $attributeField = array_pop($buffer);
                            $relationPath   = implode('.', $buffer);

                            $query->orWhereHas($relationPath, function (Builder $query) use ($attributeField, $searchTerm) {
                                $query->where($attributeField, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });
    }
}
