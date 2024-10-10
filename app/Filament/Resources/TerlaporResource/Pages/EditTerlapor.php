<?php

namespace App\Filament\Resources\TerlaporResource\Pages;

use App\Filament\Resources\TerlaporResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class EditTerlapor extends EditRecord
{
    protected static string $resource = TerlaporResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make()->label('Hapus'),
        ];
    }

    public function getTitle(): string
    {
        return 'Ubah Terlapor';
    }

    public function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }
}
