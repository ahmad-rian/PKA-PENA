<?php

namespace App\Filament\Resources\KonselorResource\Pages;

use App\Filament\Resources\KonselorResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditKonselor extends EditRecord
{
    protected static string $resource = KonselorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }
}
