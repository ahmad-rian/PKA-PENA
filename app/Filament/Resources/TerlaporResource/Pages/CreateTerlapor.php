<?php

namespace App\Filament\Resources\TerlaporResource\Pages;

use App\Filament\Resources\TerlaporResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateTerlapor extends CreateRecord
{
    protected static string $resource = TerlaporResource::class;

    public function getRedirectUrl(): string
    {
        return route('filament.admin.resources.aduans.index');
    }

    public function getTitle(): string
    {
        return 'Buat Terlapor Baru';
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
