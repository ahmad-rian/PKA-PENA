<?php

namespace App\Filament\Resources\AdvokatResource\Pages;

use App\Filament\Resources\AdvokatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvokats extends ListRecords
{
    protected static string $resource = AdvokatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
