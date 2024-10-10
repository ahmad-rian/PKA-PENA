<?php

namespace App\Filament\Resources\JenisKasusResource\Pages;

use App\Filament\Resources\JenisKasusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisKasuses extends ListRecords
{
    protected static string $resource = JenisKasusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Baru'),
        ];
    }

    public function getTitle(): string
    {
        return 'Daftar Jenis Kasus';
    }
}
