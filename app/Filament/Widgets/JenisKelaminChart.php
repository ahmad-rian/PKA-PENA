<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class JenisKelaminChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Jenis Kelamin Korban';

    use InteractsWithPageFilters;

    protected function getData(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $startDate = $start ? Carbon::parse($start) : now()->subMonths(6);

        $endDate = $end ? Carbon::parse($end) : now();

        // Retrieve data from the database and group by gender
        $data = DB::table('korbans')
            ->join('aduan_korban', 'korbans.id', '=', 'aduan_korban.korban_id')
            ->join('aduans', 'aduan_korban.aduan_id', '=', 'aduans.id')
            ->select('korbans.jenis_kelamin_korban', DB::raw('count(*) as total'))
            ->whereBetween('aduans.tanggal_masuk', [$startDate, $endDate])
            ->groupBy('korbans.jenis_kelamin_korban')
            ->get();

        // Map data to labels and values for the chart
        $labels = $data->pluck('jenis_kelamin_korban')->toArray();
        $values = $data->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Distribusi Jenis Kelamin',
                    'data' => $values,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
