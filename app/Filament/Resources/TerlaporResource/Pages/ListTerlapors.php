<?php

namespace App\Filament\Resources\TerlaporResource\Pages;

use App\Filament\Resources\TerlaporResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerlapors extends ListRecords
{
    protected static string $resource = TerlaporResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
