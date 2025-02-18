<x-filament-panels::page>
    <h2 class="text-green-400 font-bold text-2xl">{{ config('app.name') }}</h2>

    langue : {{$locale}}
    <p>
        <a href="{{route('information',['locale'=>'fr'])}}">information fr</a>
    </p>
    <p>
        <a href="{{route('information',['locale'=>'en'])}}">information en</a>
    </p>
</x-filament-panels::page>
