<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-row items-center justify-center">
            <img src="{{asset('images/logoMarcheur.jpg')}}" alt="logo marcheur" class="w-56 ml-8">
            <h1 class="text-3xl font-bold walker-primary text-center">Les Marcheurs de la Famenne</h1>
        </div>

        <div class="text-center">
            <h2 class="text-2xl walker-secondary text-center my-4">Sie einladen</h2>

            <h3 class="text-2xl font-semibold walker-primary text-center mt-6"> au 100 KM – FAMENNE – ARDENNE</h3>

            <p class="text-lg text-center font-bold">Freitag, den 29. August 2025 - Abfahrt um 21 Uhr</p>
            @include('filament.pages.parts._btn_signup')
        </div>

        <h3 class="text-2xl font-semibold walker-primary mt-6">und zu den andere Wege</h3>
        <p class="text-lg ">Am Samstag, den 30. August 2025</p>

        <table class="w-full border-collapse mt-6 max-w-xl">
            <thead>
            <tr class="bg-green-600 text-white">
                <th class="p-2">Entfernung</th>
                <th class="p-2">Zeitplan</th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b">
                <td class="p-2">50 km</td>
                <td class="p-2">6h-8uhr</td>
            </tr>
            <tr class="border-b">
                <td class="p-2">37 km</td>
                <td class="p-2">6h-10uhr</td>
            </tr>
            <tr class="border-b">
                <td class="p-2">21 km</td>
                <td class="p-2">6h-12uhr</td>
            </tr>
            <tr>
                <td class="p-2">6-14 km</td>
                <td class="p-2">6h-15uhr</td>
            </tr>
            </tbody>
        </table>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">START</h3>
        <p class="font-semibold">uur - Freitag 29 août um 21h</p>
        <p class="font-semibold">Institut Ste Julie</p>
        <p>
            <a href="https://maps.app.goo.gl/NunW5AvTdTgLcK1b7" target="_blank" class="underline">
                Rue de Nérette 2, 6900 – MARCHE-en-FAMENNE
            </a>
        </p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">ANMELDUNG</h3>
        <p>Anmeldung vor dem 1. August 2025 : <span class="font-semibold">45 €</span></p>
        <p>Anmeldung nach dem 1. August 2025 : <span class="font-semibold">50 €</span> / Ohne T-shirt</p>
        <p class="mt-2">Dieser Preis beinhaltet: T-Shirt, Frühstück auf halber Strecke und Verpflegung.</p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">WICHTIG</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>Das Mindestalter ist 16 Jahre.</li>
            <li>Eine fluoreszierende Jacke und eine Stirnlampe sind Pflicht.</li>
            <li>Der Gepäcktransport ist auf halbem Weg.</li>
            <li>Die 100 km müssen in maximal 24 Stunden zurückgelegt werden.</li>
            <li>Die Verpflegungsstände werden vom Organisator bereitgestellt.</li>
            <li>Die Wanderung findet auch bei ungünstigen Wetterbedingungen statt.</li>
            <li>Die Anmeldung zur Wanderung ist gleichbedeutend mit einem Gesundheitszeugnis.</li>
        </ul>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">SECRETARIAT</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>Das Sekretariat ist am Freitag, den 29. August 2025, ab 17.30 Uhr geöffnet.</li>
            <li>Die Sprechstunde von FFBMP und IVV am Samstag, den 30. August 2025, von 9.00 bis 21.00 Uhr.</li>
        </ul>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">AUSKUNFT</h3>
        <p>KRINS Jean-François – <a href="mailto:jfkrins@yahoo.fr" class="text-green-600 underline">jfkrins@yahoo.fr</a>
            – +32 497 500 037</p>

        <div class="my-6">
            <a href="https://marcheursdelafamenne.marche.be" target="_blank"
               class="text-green-600 underline font-semibold">https://marcheursdelafamenne.marche.be</a>
        </div>

        @include('filament.pages.parts._logos')
    </div>

</x-filament-panels::page>
