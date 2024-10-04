<?php

namespace App\Filament\Widgets;



use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class JenisKekerasanChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Kasus dan Korban Berdasarkan Jenis Kekerasan';

    use InteractsWithPageFilters;

    protected function getData(): array
    {

        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $startDate = $start ? Carbon::parse($start) : now()->subMonths(6);

        $endDate = $end ? Carbon::parse($end) : now();

        // Define a mapping of long names to short names
        $labelMapping = [
            'Anak dalam Situasi Darurat' => 'Jenis 1',
            'Anak Kelompok Minoritas dan Terisolasi' => 'Jenis 2',
            'Anak Berhadapan dengan Hukum' => 'Jenis 3',
            'Anak Korban Eksploitasi Ekonomi dan Eksploitasi Seksual' => 'Jenis 4',
            'Anak Korban Kekerasan Fisik' => 'Jenis 5',
            'Anak Korban Kekerasan Psikis' => 'Jenis 6',
            'Anak Korban Penyalahgunaan Napza' => 'Jenis 7',
        ];

        // Initialize the dataset with all labels set to zero count for cases and victims
        $initialData = collect($labelMapping)->mapWithKeys(function ($shortLabel) {
            return [$shortLabel => ['cases' => 0, 'victims' => 0]];
        });

        // Retrieve the count of each jenis_kasus from the many-to-many relationship
        $caseData = DB::table('aduan_jenis_kasus')
            ->join('jenis_kasuses', 'aduan_jenis_kasus.jenis_kasus_id', '=', 'jenis_kasuses.id')
            ->join('aduans', 'aduan_jenis_kasus.aduan_id', '=', 'aduans.id')
            ->select('jenis_kasuses.jenis_kasus', DB::raw('count(*) as count'))
            ->whereBetween('aduans.tanggal_masuk', [$startDate, $endDate])
            ->groupBy('jenis_kasuses.jenis_kasus')
            ->orderBy('count', 'desc')
            ->get();

        // Retrieve the count of victims per jenis_kasus
        $victimData = DB::table('aduan_jenis_kasus')
            ->join('jenis_kasuses', 'aduan_jenis_kasus.jenis_kasus_id', '=', 'jenis_kasuses.id')
            ->join('aduans', 'aduan_jenis_kasus.aduan_id', '=', 'aduans.id')
            ->join('aduan_korban', 'aduans.id', '=', 'aduan_korban.aduan_id')
            ->join('korbans', 'aduan_korban.korban_id', '=', 'korbans.id')
            ->select('jenis_kasuses.jenis_kasus', DB::raw('count(korbans.nama_korban) as count'))
            ->whereBetween('aduans.tanggal_masuk', [$startDate, $endDate])
            ->groupBy('jenis_kasuses.jenis_kasus')
            ->orderBy('count', 'desc')
            ->get();

        // Map the retrieved case data to the short labels
        $mappedCaseData = $caseData->pluck('count', 'jenis_kasus')->mapWithKeys(function ($count, $jenis_kasus) use ($labelMapping) {
            return [$labelMapping[$jenis_kasus] ?? $jenis_kasus => ['cases' => $count]];
        });

        // Map the retrieved victim data to the short labels
        $mappedVictimData = $victimData->pluck('count', 'jenis_kasus')->mapWithKeys(function ($count, $jenis_kasus) use ($labelMapping) {
            return [$labelMapping[$jenis_kasus] ?? $jenis_kasus => ['victims' => $count]];
        });

        // Merge the initial data with the mapped case and victim data to ensure all labels are present
        $finalData = $initialData->merge($mappedCaseData)->mergeRecursive($mappedVictimData);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kasus',
                    'data' => $finalData->pluck('cases')->values()->toArray(),
                    'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                    'borderColor' => 'rgba(255, 159, 64, 1)',
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
            'Jenis 1' => 'Anak dalam Situasi Darurat',
            'Jenis 2' => 'Anak Kelompok Minoritas dan Terisolasi',
            'Jenis 3' => 'Anak Berhadapan dengan Hukum',
            'Jenis 4' => 'Anak Korban Eksploitasi Ekonomi dan Eksploitasi Seksual',
            'Jenis 5' => 'Anak Korban Kekerasan Fisik',
            'Jenis 6' => 'Anak Korban Kekerasan Psikis',
            'Jenis 7' => 'Anak Korban Penyalahgunaan Napza',
        ];

        $chart = parent::render();

        return view('filament.widgets.jenis_kekerasan_chart', [
            'chart' => $chart,
            'explanations' => $explanations,
        ]);
    }
}
