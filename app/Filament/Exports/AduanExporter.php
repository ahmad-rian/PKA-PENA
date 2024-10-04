<?php

namespace App\Filament\Exports;

use App\Models\Aduan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AduanExporter extends Exporter
{
    protected static ?string $model = Aduan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('kode_kasus'),
            ExportColumn::make('tanggal_masuk'),
            ExportColumn::make('kanal_pengaduan'),
            ExportColumn::make('kewenangan'),
            ExportColumn::make('tanggal_kejadian'),
            ExportColumn::make('provinsi_kejadian'),
            ExportColumn::make('tempat_kejadian'),
            ExportColumn::make('sumber_tambahan'),
            ExportColumn::make('kronologi_singkat'),
            ExportColumn::make('manajer_id'),
            ExportColumn::make('advokat_id'),
            ExportColumn::make('peksos_id'),
            ExportColumn::make('psikolog_id'),
            ExportColumn::make('konselor_id'),
            ExportColumn::make('paralegal_id'),
            ExportColumn::make('layanan_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your aduan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
