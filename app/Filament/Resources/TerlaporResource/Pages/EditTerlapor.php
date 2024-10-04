<?php

namespace App\Filament\Resources\TerlaporResource\Pages;

use App\Filament\Resources\TerlaporResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTerlapor extends EditRecord
{
    protected static string $resource = TerlaporResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
