<?php

namespace App\Filament\Resources\KonselorResource\Pages;

use App\Filament\Resources\KonselorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonselors extends ListRecords
{
    protected static string $resource = KonselorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
