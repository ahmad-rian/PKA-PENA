{{-- resources/views/filament/widgets/jumlah-type-overview.blade.php --}}

<x-filament::stats-overview>
    <x-filament::stats-overview.stat :label="'Jumlah Aduan'" :value="$stats[0]['value']" :description="$stats[0]['description']" />
    <x-filament::stats-overview.stat :label="'Jumlah Korban'" :value="$stats[1]['value']" :description="$stats[1]['description']" />
    <x-filament::stats-overview.stat :label="'Jumlah Terlapor'" :value="$stats[2]['value']" :description="$stats[2]['description']" />
</x-filament::stats-overview>
