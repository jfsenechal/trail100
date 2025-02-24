<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-row items-center justify-center">
            <img src="{{asset('images/logoMarcheur.jpg')}}" alt="logo marcheur" class="w-56 ml-8">
            <h1 class="text-3xl font-bold walker-primary text-center">Les Marcheurs de la Famenne</h1>
        </div>

        <div class="text-center">
            <h2 class="text-2xl walker-secondary text-center my-4">Invite you</h2>

            <h3 class="text-3xl font-semibold walker-primary text-center mt-6"> to the 100 KM – FAMENNE – ARDENNE</h3>

            <p class="text-lg text-center font-bold">Friday, August 29, 2025 - Departure at 9 p.m.</p>
            @include('filament.pages.parts._btn_signup')
        </div>

        <h3 class="text-2xl font-semibold walker-primary mt-6">and other walks</h3>
        <p class="text-lg ">Saturday, August 30, 2025</p>

        <table class="w-full border-collapse mt-6 max-w-xl">
            <thead>
            <tr class="bg-green-600 text-white">
                <th class="p-2">Distance</th>
                <th class="p-2">Duration</th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b">
                <td class="p-2">50 km</td>
                <td class="p-2">6h-8h</td>
            </tr>
            <tr class="border-b">
                <td class="p-2">37 km</td>
                <td class="p-2">6h-10h</td>
            </tr>
            <tr class="border-b">
                <td class="p-2">21 km</td>
                <td class="p-2">6h-12h</td>
            </tr>
            <tr>
                <td class="p-2">6-14 km</td>
                <td class="p-2">6h-15h</td>
            </tr>
            </tbody>
        </table>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">DEPARTURE</h3>
        <p class="font-semibold">Friday, August 29, 2025 at 9 p.m.</p>
        <p class="font-semibold">Institut Ste Julie</p>
        <p>
            <a href="https://maps.app.goo.gl/NunW5AvTdTgLcK1b7" target="_blank" class="underline">
                Rue de Nérette 2, 6900 – MARCHE-en-FAMENNE
            </a>
        </p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">REGISTRATION</h3>
        <p>Before August 1, 2025 : <span class="font-semibold">45 €</span></p>
        <p>After August 1, 2025 : <span class="font-semibold">50 €</span> / Without T-shirt</p>
        <p class="mt-2">This price includes: t-shirt, mid-course breakfast and refreshments.</p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">IMPORTANT</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>The minimum age is 16 years old.</li>
            <li>A fluorescent jacket and a headlamp are mandatory.</li>
            <li>Luggage transport is halfway through.</li>
            <li>The 100 km must be covered in a maximum of 24 hours.</li>
            <li>Refreshments are provided by the organizer.</li>
            <li>The walk will take place even if the weather conditions are unfavorable.</li>
            <li>Registration for the walk is worth a certificate of good health.</li>
        </ul>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">INFORMATION</h3>
        <p>DEGEYE Philippe – <a href="mailto:degeye.philippe@gmail.com" class="text-green-600 underline">degeye.philippe@gmail.com</a>
            – +32 476 545 951</p>

        <div class="my-6">
            <a href="https://marcheursdelafamenne.marche.be" target="_blank"
               class="text-green-600 underline font-semibold">https://marcheursdelafamenne.marche.be</a>
        </div>

        @include('filament.pages.parts._logos')
    </div>

</x-filament-panels::page>
