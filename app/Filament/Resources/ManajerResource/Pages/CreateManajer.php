<?php

namespace App\Filament\Resources\ManajerResource\Pages;

use App\Filament\Resources\ManajerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManajer extends CreateRecord
{
    protected static string $resource = ManajerResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
