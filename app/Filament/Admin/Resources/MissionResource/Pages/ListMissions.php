<?php

namespace App\Filament\Admin\Resources\MissionResource\Pages;

use App\Filament\Admin\Resources\MissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMissions extends ListRecords
{
    protected static string $resource = MissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nova Missão')
                ->icon('heroicon-o-plus-circle'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todas')
                ->icon('heroicon-o-queue-list')
                ->badge(fn () => \App\Models\Mission::count()),

            'active' => Tab::make('Ativas')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('challenge_start_date', '<=', now())
                          ->where('challenge_end_date', '>=', now())
                )
                ->badge(fn () => \App\Models\Mission::where('challenge_start_date', '<=', now())
                    ->where('challenge_end_date', '>=', now())
                    ->count())
                ->badgeColor('success'),

            'upcoming' => Tab::make('Em Breve')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('challenge_start_date', '>', now())
                )
                ->badge(fn () => \App\Models\Mission::where('challenge_start_date', '>', now())->count())
                ->badgeColor('warning'),

            'expired' => Tab::make('Expiradas')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('challenge_end_date', '<', now())
                )
                ->badge(fn () => \App\Models\Mission::where('challenge_end_date', '<', now())->count())
                ->badgeColor('danger'),

            'featured' => Tab::make('Em Destaque')
                ->icon('heroicon-o-star')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('is_featured', true)
                )
                ->badge(fn () => \App\Models\Mission::where('is_featured', true)->count())
                ->badgeColor('warning'),
        ];
    }
}
