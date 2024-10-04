<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class LayananChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Kasus dan Korban Berdasarkan Layanan';

    use InteractsWithPageFilters;

    protected function getData(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $startDate = $start ? Carbon::parse($start) : now()->subMonths(6);

        $endDate = $end ? Carbon::parse($end) : now();

        // Definisikan pemetaan nama panjang ke nama pendek
        $labelMapping = [
            'PENGADUAN MASYARAKAT' => 'Jenis 1',
            'PENJANGKAUAN KORBAN' => 'Jenis 2',
            'PENGELOLAAN KASUS' => 'Jenis 3',
            'PENAMPUNGAN SEMENTARA' => 'Jenis 4',
            'MEDIASI' => 'Jenis 5',
            'PENDAMPINGAN KORBAN' => 'Jenis 6',
        ];

        // Inisialisasi dataset dengan semua label yang di-set ke nilai nol
        $initialData = collect($labelMapping)->mapWithKeys(function ($shortLabel) {
            return [$shortLabel => ['cases' => 0, 'victims' => 0]];
        });

        // Ambil jumlah kasus berdasarkan layanan
        $caseData = DB::table('aduan_jenis_layanan')
            ->join('layanans', 'aduan_jenis_layanan.layanan_id', '=', 'layanans.id')
            ->join('aduans', 'aduan_jenis_layanan.aduan_id', '=', 'aduans.id')
            ->select('layanans.jenis_layanan', DB::raw('count(*) as count'))
            ->when($startDate, fn ($query) => $query->where('aduans.tanggal_masuk', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->where('aduans.tanggal_masuk', '<=', $endDate))
            ->groupBy('layanans.jenis_layanan')
            ->get();

        // Ambil jumlah korban berdasarkan layanan
        $victimData = DB::table('aduan_jenis_layanan')
            ->join('layanans', 'aduan_jenis_layanan.layanan_id', '=', 'layanans.id')
            ->join('aduans', 'aduan_jenis_layanan.aduan_id', '=', 'aduans.id')
            ->join('aduan_korban', 'aduans.id', '=', 'aduan_korban.aduan_id')
            ->join('korbans', 'aduan_korban.korban_id', '=', 'korbans.id')
            ->select('layanans.jenis_layanan', DB::raw('count(korbans.id) as count'))
            ->when($startDate, fn ($query) => $query->where('aduans.tanggal_masuk', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->where('aduans.tanggal_masuk', '<=', $endDate))
            ->groupBy('layanans.jenis_layanan')
            ->get();

        // Mapping data kasus
        $mappedCaseData = $caseData->pluck('count', 'jenis_layanan')->mapWithKeys(function ($count, $jenis_layanan) use ($labelMapping) {
            return [$labelMapping[$jenis_layanan] ?? $jenis_layanan => ['cases' => $count]];
        });

        // Mapping data korban
        $mappedVictimData = $victimData->pluck('count', 'jenis_layanan')->mapWithKeys(function ($count, $jenis_layanan) use ($labelMapping) {
            return [$labelMapping[$jenis_layanan] ?? $jenis_layanan => ['victims' => $count]];
        });

        // Gabungkan data awal dengan data yang dimapping
        $finalData = $initialData->merge($mappedCaseData)->mergeRecursive($mappedVictimData);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kasus',
                    'data' => $finalData->pluck('cases')->values()->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Jumlah Korban',
                    'data' => $finalData->pluck('victims')->values()->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
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

    public function render(): View
    {
        $explanations = [
            'Jenis 1' => 'PENGADUAN MASYARAKAT',
            'Jenis 2' => 'PENJANGKAUAN KORBAN',
            'Jenis 3' => 'PENGELOLAAN KASUS',
            'Jenis 4' => 'PENAMPUNGAN SEMENTARA',
            'Jenis 5' => 'MEDIASI',
            'Jenis 6' => 'PENDAMPINGAN KORBAN',
        ];

        $chart = parent::render();

        return view('filament.widgets.layanan_chart', [
            'chart' => $chart,
            'explanations' => $explanations,
        ]);
    }
}
