<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasDateFilters
{
    public ?Carbon $startDate = null;
    public ?Carbon $endDate = null;

    public function setStartDate($date)
    {
        $this->startDate = $date ? Carbon::parse($date) : now()->subMonths(6);
    }

    public function setEndDate($date)
    {
        $this->endDate = $date ? Carbon::parse($date) : now();
    }

    public function applyDateFilters($query)
    {
        $start = $this->startDate ?? now()->subMonths(6);
        $end = $this->endDate ?? now();

        return $query->whereBetween('created_at', [$start, $end]);
    }
}
