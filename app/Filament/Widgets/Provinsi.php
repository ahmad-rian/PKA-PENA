<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Aduan; // Import the Aduan model
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Korban; // Import the Korban model
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class Provinsi extends BaseWidget
{
    protected static ?string $heading = 'Jumlah Korban Berdasarkan Provinsi';

    protected int | string | array $columnSpan = 'full';

    use InteractsWithPageFilters;

    public function table(Table $table): Table
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $startDate = $start ? Carbon::parse($start) : now()->subMonths(6);

        $endDate = $end ? Carbon::parse($end) : now();

        return $table
            ->query(
                Korban::query()
                    ->select('provinsi_korban', DB::raw('count(*) as jumlah'))
                    ->join('aduan_korban', 'korbans.id', '=', 'aduan_korban.korban_id')
                    ->join('aduans', 'aduan_korban.aduan_id', '=', 'aduans.id')
                    ->when($startDate, fn ($query) => $query->where('aduans.tanggal_masuk', '>=', $startDate))
                    ->when($endDate, fn ($query) => $query->where('aduans.tanggal_masuk', '<=', $endDate))
                    ->groupBy('provinsi_korban')
                    ->orderBy('jumlah', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(fn ($record, $rowLoop) => $rowLoop->iteration),

                Tables\Columns\TextColumn::make('provinsi_korban')
                    ->label('Nama Provinsi')
                    ->searchable(), // Search against 'provinsi_korban' directly

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah'),
            ])
            ->defaultSort('jumlah', 'desc');
    }

    public function getTableRecordKey($record): string
    {
        // Return a unique key for each record
        return (string) $record->provinsi_korban;
    }
}
