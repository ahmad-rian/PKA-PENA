<?php

namespace App\Filament\Resources\ManajerResource\Pages;

use App\Filament\Resources\ManajerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajers extends ListRecords
{
    protected static string $resource = ManajerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
