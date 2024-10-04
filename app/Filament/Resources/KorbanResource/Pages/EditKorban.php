<?php

namespace App\Filament\Resources\KorbanResource\Pages;

use App\Filament\Resources\KorbanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKorban extends EditRecord
{
    protected static string $resource = KorbanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
