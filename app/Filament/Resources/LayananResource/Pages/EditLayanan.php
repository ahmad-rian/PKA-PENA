<?php

namespace App\Filament\Resources\LayananResource\Pages;

use App\Filament\Resources\LayananResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditLayanan extends EditRecord
{
    protected static string $resource = LayananResource::class;

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
