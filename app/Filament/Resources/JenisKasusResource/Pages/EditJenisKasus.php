<?php

namespace App\Filament\Resources\JenisKasusResource\Pages;

use App\Filament\Resources\JenisKasusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisKasus extends EditRecord
{
    protected static string $resource = JenisKasusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
