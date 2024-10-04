<?php

namespace App\Filament\Resources\KonselorResource\Pages;

use App\Filament\Resources\KonselorResource;
use Filament\Actions;
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
}
