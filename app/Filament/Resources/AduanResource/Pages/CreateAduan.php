<?php

namespace App\Filament\Resources\AduanResource\Pages;

use App\Filament\Resources\AduanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAduan extends CreateRecord
{
    protected static string $resource = AduanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('Save'))
                ->createAnother(false),
        ];
    }

    public function getRedirectUrl(): string
    {
        return route('filament.admin.resources.pelapors.create');
    }
}
