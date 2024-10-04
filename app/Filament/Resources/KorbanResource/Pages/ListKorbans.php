<?php

namespace App\Filament\Resources\KorbanResource\Pages;

use App\Filament\Resources\KorbanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKorbans extends ListRecords
{
    protected static string $resource = KorbanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
