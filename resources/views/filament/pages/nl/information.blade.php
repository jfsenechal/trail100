<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-row items-center justify-center">
            <img src="{{asset('images/logoMarcheur.jpg')}}" alt="logo marcheur" class="w-56 ml-8">
            <h1 class="text-3xl font-bold walker-primary text-center">Les Marcheurs de la Famenne</h1>
        </div>

        <div class="text-center">
            <h2 class="text-2xl walker-secondary text-center my-4">Nodigen u uit</h2>

            <h3 class="text-2xl font-semibold walker-primary text-center mt-6"> au 100 KM – FAMENNE – ARDENNE</h3>

            <p class="text-lg text-center font-bold">Vrijdag 29 augustus 2025 - Vertrek om 21 uur</p>
            @include('filament.pages.parts._btn_signup')
        </div>

        <h3 class="text-2xl font-semibold walker-primary mt-6">en naar de andere routes</h3>
        <p class="text-lg ">Zaterdag 30 augustus 2025</p>

        <table class="w-full border-collapse mt-6 max-w-xl">
            <thead>
            <tr class="bg-green-600 text-white">
                <th class="p-2">Afstand</th>
                <th class="p-2">Per uur</th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b">
                <td class="p-2">50 km</td>
                <td class="p-2">6-8uur</td>
            </tr>
            <tr class="border-b">
                <td class="p-2">37 km</td>
                <td class="p-2">6-10uur</td>
            </tr>
            <tr class="border-b">
                <td class="p-2">21 km</td>
                <td class="p-2">6-12uur</td>
            </tr>
            <tr>
                <td class="p-2">6-14 km</td>
                <td class="p-2">6-15uur</td>
            </tr>
            </tbody>
        </table>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">VERTREK</h3>
        <p class="font-semibold">Vrijdag 29 augustus 2025 om 21uur</p>
        <p class="font-semibold">Institut Ste Julie</p>
        <p>
            <a href="https://maps.app.goo.gl/NunW5AvTdTgLcK1b7" target="_blank" class="underline">
                Rue de Nérette 2, 6900 – MARCHE-en-FAMENNE
            </a>
        </p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">INSCHRIJVING</h3>
        <p>Inschrijving voor 1 augustus 2025 : <span class="font-semibold">45 €</span></p>
        <p>Inschrijving na 1 augustus 2025 : <span class="font-semibold">50 €</span> / Zonder T-shirt</p>
        <p class="mt-2">In de prijs inbegrepen : t-shirt, ontbijt halverwege en bevoorrading.</p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">BELANGRIJK</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>Minimumleeftijd is 16 jarr.</li>
            <li>Een fluorescerende jas en hoofdkamp zijn verplicht.</li>
            <li>Bagagevervoer : halverwege.</li>
            <li>De 100 km moeten afgelegd worden maximum 24 uur.</li>
            <li>Bevoorading in verzogd door de organisatoren.</li>
            <li>De wandeltocht vindt plaat ongeacht het weer.</li>
            <li>Inschrijving voor de wandeltocht is gelijkwaardig aan bewijs van goede gezondheid.</li>
        </ul>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">SECRETARIAAT</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>Het secretariaat is geopend op vrijdag 29 augustus 2025 vanaf 17uur30.</li>
            <li> Informatiebalie van FFBMP en IVV op zaterdag 30 augustus 2025 van 9uur tot 21uur</li>
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
