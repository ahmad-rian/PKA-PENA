<?php

namespace App\Filament\Resources\PeksosResource\Pages;

use App\Filament\Resources\PeksosResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeksos extends CreateRecord
{
    protected static string $resource = PeksosResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    public function getTitle(): string
    {
        return 'Buat Peksos';
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

    protected function getCreateFormAction(): Actions\Action
    {
        return Actions\Action::make('create')
            ->label('Buat')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    protected function getCreateAnotherFormAction(): Actions\Action
    {
        return Actions\Action::make('createAnother')
            ->label('Buat dan buat lagi')
            ->action('createAnother')
            ->keyBindings(['mod+shift+s']);
    }
}
