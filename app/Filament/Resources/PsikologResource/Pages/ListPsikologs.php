<?php

namespace App\Filament\Resources\PsikologResource\Pages;

use App\Filament\Resources\PsikologResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPsikologs extends ListRecords
{
    protected static string $resource = PsikologResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
