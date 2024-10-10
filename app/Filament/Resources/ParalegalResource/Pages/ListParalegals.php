<?php

namespace App\Filament\Resources\ParalegalResource\Pages;

use App\Filament\Resources\ParalegalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParalegals extends ListRecords
{
    protected static string $resource = ParalegalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Baru'),
        ];
    }

    public function getTitle(): string
    {
        return 'Daftar Paralegal';
    }
}
