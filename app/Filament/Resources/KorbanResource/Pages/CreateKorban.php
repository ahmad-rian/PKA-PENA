<?php

namespace App\Filament\Resources\KorbanResource\Pages;

use App\Filament\Resources\KorbanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateKorban extends CreateRecord
{
    protected static string $resource = KorbanResource::class;

    public function getRedirectUrl(): string
    {
        return route('filament.admin.resources.terlapors.create');
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
