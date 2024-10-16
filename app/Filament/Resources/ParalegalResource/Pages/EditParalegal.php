<?php

namespace App\Filament\Resources\ParalegalResource\Pages;

use App\Filament\Resources\ParalegalResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditParalegal extends EditRecord
{
    protected static string $resource = ParalegalResource::class;

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
