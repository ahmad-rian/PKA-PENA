<!-- resources/views/filament/widgets/jenis_kekerasan_chart.blade.php -->

<x-filament::card>
    {!! $chart !!}
    <div class="mt-4">
        <h4>Keterangan:</h4>
        <br />
        <ul>
            @foreach ($explanations as $shortLabel => $fullLabel)
                <li><strong>{{ $shortLabel }}:</strong> {{ $fullLabel }}</li>
            @endforeach
        </ul>
    </div>
</x-filament::card>
