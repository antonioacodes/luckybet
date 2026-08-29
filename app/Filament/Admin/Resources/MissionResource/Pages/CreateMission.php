<?php

namespace App\Filament\Admin\Resources\MissionResource\Pages;

use App\Filament\Admin\Resources\MissionResource;
use App\Models\Game;
use Filament\Resources\Pages\CreateRecord;

class CreateMission extends CreateRecord
{
    protected static string $resource = MissionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Se não tiver imagem personalizada, busca do jogo
        if (empty($data['challenge_image']) && !empty($data['challenge_gameid'])) {
            $game = Game::where('game_id', $data['challenge_gameid'])->first();
            if ($game && $game->cover) {
                // Se a cover do jogo já é uma URL completa
                if (filter_var($game->cover, FILTER_VALIDATE_URL)) {
                    $data['challenge_image'] = $game->cover;
                } else {
                    // Se é um caminho relativo
                    $data['challenge_image'] = asset('storage/' . $game->cover);
                }
            }
        }

        // Garantir valores padrão baseado no tipo de recompensa
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

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Missão criada com sucesso!';
    }
}
