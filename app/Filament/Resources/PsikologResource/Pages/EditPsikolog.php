<?php

namespace App\Filament\Resources\PsikologResource\Pages;

use App\Filament\Resources\PsikologResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditPsikolog extends EditRecord
{
    protected static string $resource = PsikologResource::class;

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
