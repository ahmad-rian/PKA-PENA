<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\View\View;

class KanalPengaduanChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Jumlah Kasus Berdasarkan Kanal Pengaduan';

    protected function getData(): array
    {
        // Retrieve start and end dates from filters or set defaults
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;
        $startDate = $start ? Carbon::parse($start) : now()->subMonths(6);
        $endDate = $end ? Carbon::parse($end) : now();

        // Define label mappings
        $labelMapping = [
            'NON ADUAN - LAPORAN MEDIA' => 'Jenis 1',
            'NOTA DINAS' => 'Jenis 2',
            'PENGADUAN LANGSUNG' => 'Jenis 3',
            'SAPA 129 - GFORM' => 'Jenis 4',
            'SAPA 129 - HOTLINE WA' => 'Jenis 5',
            'SAPA 129 - TELEPON' => 'Jenis 6',
            'SP4N LAPOR' => 'Jenis 7',
            'SURAT' => 'Jenis 8',
            'Mobile Apps' => 'Jenis 9',
        ];

        // Initialize data with default values
        $initialData = collect($labelMapping)->mapWithKeys(function ($shortLabel) {
            return [$shortLabel => 0];
        });

        // Fetch data from the database
        $data = DB::table('aduans')
            ->select('kanal_pengaduan', DB::raw('count(*) as count'))
            ->when($startDate, fn ($query) => $query->where('tanggal_masuk', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->where('tanggal_masuk', '<=', $endDate))
            ->groupBy('kanal_pengaduan')
            ->orderBy('count', 'desc')
            ->get();

        // Map data to labels
        $mappedData = $data->pluck('count', 'kanal_pengaduan')->mapWithKeys(function ($count, $kanal_pengaduan) use ($labelMapping) {
            return [$labelMapping[$kanal_pengaduan] ?? $kanal_pengaduan => $count];
        });

        // Merge data to ensure all labels are included
        $finalData = $initialData->merge($mappedData);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kasus Berdasarkan Kanal Pengaduan',
                    'data' => $finalData->values()->toArray(),
                    'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                    'borderColor' => 'rgba(255, 159, 64, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $finalData->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // Ensure widget updates when filters change
    protected function updatedFilters(): void
    {
        // Clear the cache for data to force update
        $this->clearCachedData();
    }

    public function render(): View
    {
        $explanations = [
            'Jenis 1' => 'NON ADUAN - LAPORAN MEDIA',
            'Jenis 2' => 'NOTA DINAS',
            'Jenis 3' => 'PENGADUAN LANGSUNG',
            'Jenis 4' => 'SAPA 129 - GFORM',
            'Jenis 5' => 'SAPA 129 - HOTLINE WA',
            'Jenis 6' => 'SAPA 129 - TELEPON',
            'Jenis 7' => 'SP4N LAPOR',
            'Jenis 8' => 'SURAT',
            'Jenis 9' => 'Mobile Apps',
        ];

        return view('filament.widgets.kanal_chart', [
            'chart' => parent::render(),
            'explanations' => $explanations,
        ]);
    }
}
