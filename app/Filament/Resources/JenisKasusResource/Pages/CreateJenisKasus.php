<?php

namespace App\Filament\Resources\JenisKasusResource\Pages;

use App\Filament\Resources\JenisKasusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisKasus extends CreateRecord
{
    protected static string $resource = JenisKasusResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
