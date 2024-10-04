<?php

namespace App\Filament\Resources\PeksosResource\Pages;

use App\Filament\Resources\PeksosResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeksos extends CreateRecord
{
    protected static string $resource = PeksosResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
