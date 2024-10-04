<?php

namespace App\Filament\Resources\TerlaporResource\Pages;

use App\Filament\Resources\TerlaporResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTerlapor extends CreateRecord
{
    protected static string $resource = TerlaporResource::class;

    public function getRedirectUrl(): string
    {
        return route('filament.admin.resources.aduans.index');
    }
}
