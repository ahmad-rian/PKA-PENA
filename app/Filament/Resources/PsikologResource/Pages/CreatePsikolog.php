<?php

namespace App\Filament\Resources\PsikologResource\Pages;

use App\Filament\Resources\PsikologResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePsikolog extends CreateRecord
{
    protected static string $resource = PsikologResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
