<?php

namespace App\Filament\Resources\AduanResource\Pages;

use App\Filament\Resources\AduanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateAduan extends CreateRecord
{
    protected static string $resource = AduanResource::class;

    public function getTitle(): string
    {
        return 'Buat Aduan';
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('cancel')
                ->label('Batal')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCreateAnotherFormAction(),
        ];
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Buat')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label('Buat dan buat lagi')
            ->action('createAnother')
            ->keyBindings(['mod+shift+s']);
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
