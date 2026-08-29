<?php

namespace App\Filament\Admin\Resources\MissionResource\Pages;

use App\Filament\Admin\Resources\MissionResource;
use App\Models\Game;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMission extends EditRecord
{
    protected static string $resource = MissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('duplicate')
                ->label('Duplicar Missão')
                ->icon('heroicon-o-document-duplicate')
                ->color('warning')
                ->action(function () {
                    $data = $this->record->toArray();
                    unset($data['id'], $data['created_at'], $data['updated_at']);
                    $data['challenge_name'] = $data['challenge_name'] . ' (Cópia)';
                    
                    $newRecord = static::getResource()::getModel()::create($data);
                    
                    $this->notify('success', 'Missão duplicada!', 'Uma cópia desta missão foi criada com sucesso.');
                    
                    return redirect()->to(static::getResource()::getUrl('edit', ['record' => $newRecord]));
                })
                ->requiresConfirmation(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Se não tiver imagem personalizada, busca do jogo
        if (empty($data['challenge_image']) && !empty($data['challenge_gameid'])) {
            $game = Game::where('game_id', $data['challenge_gameid'])->first();
            if ($game && $game->cover) {
                if (filter_var($game->cover, FILTER_VALIDATE_URL)) {
                    $data['challenge_image'] = $game->cover;
                } else {
                    $data['challenge_image'] = asset('storage/' . $game->cover);
                }
            }
        }

        // Garantir valores padrão
        if ($data['reward_type'] === 'bonus') {
            $data['reward_freespins'] = 0;
        } else {
            $data['challenge_bonus'] = 0.00;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Missão atualizada com sucesso!';
    }
}
