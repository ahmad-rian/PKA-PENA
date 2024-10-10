<?php

namespace App\Filament\Resources\AduanResource\Pages;

use App\Filament\Resources\AduanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditAduan extends EditRecord
{
    protected static string $resource = AduanResource::class;

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
