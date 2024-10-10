<?php

namespace App\Filament\Resources\TerlaporResource\Pages;

use App\Filament\Resources\TerlaporResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerlapors extends ListRecords
{
    protected static string $resource = TerlaporResource::class;

    public function getTitle(): string
    {
        return 'Daftar Terlapor';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Terlapor Baru'),
        ];
    }

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\Action::make('kembali')
    //             ->label('Kembali')
    //             ->url($this->getResource()::getUrl('index'))
    //             ->color('gray'),
    //     ];
    // }
}
