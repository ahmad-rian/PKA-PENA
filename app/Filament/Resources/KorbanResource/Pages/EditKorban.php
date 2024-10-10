<?php

namespace App\Filament\Resources\KorbanResource\Pages;

use App\Filament\Resources\KorbanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditKorban extends EditRecord
{
    protected static string $resource = KorbanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Ubah Koban';
    }

    public function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }
}
