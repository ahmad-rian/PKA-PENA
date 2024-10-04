<?php

namespace App\Filament\Resources\KorbanResource\Pages;

use App\Filament\Resources\KorbanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKorban extends CreateRecord
{
    protected static string $resource = KorbanResource::class;

    public function getRedirectUrl(): string
    {
        return route('filament.admin.resources.terlapors.create');
    }
}
