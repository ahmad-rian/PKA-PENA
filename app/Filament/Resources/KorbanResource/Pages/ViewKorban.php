<?php

namespace App\Filament\Resources\KorbanResource\Pages;

use App\Filament\Resources\KorbanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKorban extends ViewRecord
{
    protected static string $resource = KorbanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('ubah'),
        ];
    }
}
