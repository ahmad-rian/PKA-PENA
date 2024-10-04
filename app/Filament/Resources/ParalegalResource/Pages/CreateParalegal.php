<?php

namespace App\Filament\Resources\ParalegalResource\Pages;

use App\Filament\Resources\ParalegalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParalegal extends CreateRecord
{
    protected static string $resource = ParalegalResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
