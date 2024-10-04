<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Carbon;
use App\Models\Aduan;
use App\Models\Korban;
use App\Models\Terlapor;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JumlahTypeOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        // Retrieve the start and end dates from filters
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        // Parse dates or set default values
        $startDate = $start ? Carbon::parse($start) : now()->subMonths(6);
        $endDate = $end ? Carbon::parse($end) : now();

        return [
            Stat::make('Jumlah Aduan', Aduan::query()
                ->when($startDate, fn ($query) => $query->where('tanggal_masuk', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->where('tanggal_masuk', '<=', $endDate))
                ->count())
                ->description(''),

            Stat::make('Jumlah Korban', Korban::query()
                ->join('aduan_korban', 'korbans.id', '=', 'aduan_korban.korban_id')
                ->join('aduans', 'aduan_korban.aduan_id', '=', 'aduans.id')
                ->when($startDate, fn ($query) => $query->where('aduans.tanggal_masuk', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->where('aduans.tanggal_masuk', '<=', $endDate))
                ->count())
                ->description(''),

            Stat::make('Jumlah Terlapor', Terlapor::query()
                ->join('aduan_terlapor', 'terlapors.id', '=', 'aduan_terlapor.terlapor_id')
                ->join('aduans', 'aduan_terlapor.aduan_id', '=', 'aduans.id')
                ->when($startDate, fn ($query) => $query->where('aduans.tanggal_masuk', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->where('aduans.tanggal_masuk', '<=', $endDate))
                ->count())
                ->description(''),
        ];
    }

    // Refresh the widget when filters are updated
    protected function updatedFilters(): void
    {
        $this->cachedStats = null;
        $this->emit('refreshWidgets'); // Optional: emit event to refresh widgets if needed
    }
}
