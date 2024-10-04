<?php

namespace App\Filament\Resources\AdvokatResource\Pages;

use App\Filament\Resources\AdvokatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdvokat extends CreateRecord
{
    protected static string $resource = AdvokatResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
