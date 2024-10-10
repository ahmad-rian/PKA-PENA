<?php

namespace App\Filament\Resources\ManajerResource\Pages;

use App\Filament\Resources\ManajerResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditManajer extends EditRecord
{
    protected static string $resource = ManajerResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    public function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }
}
