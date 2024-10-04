<?php

namespace App\Filament\Resources\PeksosResource\Pages;

use App\Filament\Resources\PeksosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeksos extends ListRecords
{
    protected static string $resource = PeksosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
