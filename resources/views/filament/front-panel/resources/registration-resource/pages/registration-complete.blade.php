<x-filament-panels::page>

    <table class="table">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>T-shirt</th>
            <th>Prix</th>
        </tr>
        @foreach ($record->walkers as $walker)
            <tr>
                <td>{{ $walker->first_name }}</td>
                <td>{{ $walker->last_name }}</td>
                <td>{{ $walker->amount() }}</td>
            </tr>
        @endforeach
    </table>

    Total {{$record->totalAmount()}}
</x-filament-panels::page>
