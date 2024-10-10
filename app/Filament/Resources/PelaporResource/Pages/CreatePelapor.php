<?php

namespace App\Filament\Resources\PelaporResource\Pages;

use App\Filament\Resources\PelaporResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePelapor extends CreateRecord
{
    protected static string $resource = PelaporResource::class;

    public function getRedirectUrl(): string
    {
        return route('filament.admin.resources.korbans.create');
    }

    public function getTitle(): string
    {
        return 'Buat Pelapor Baru';
    }

    public function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Buat')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    public function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label('Buat dan buat lagi')
            ->action('createAnother')
            ->keyBindings(['mod+shift+s']);
    }
}
