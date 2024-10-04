<?php

namespace App\Filament\Resources\KonselorResource\Pages;

use App\Filament\Resources\KonselorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKonselor extends CreateRecord
{
    protected static string $resource = KonselorResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
