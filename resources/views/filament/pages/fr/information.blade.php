<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-row items-center justify-center">
            <img src="{{asset('images/logoMarcheur.jpg')}}" alt="logo marcheur" class="w-56 ml-8">
            <h1 class="text-3xl font-bold walker-primary text-center">Les Marcheurs de la Famenne</h1>
        </div>

        <div class="text-center">
            <h2 class="text-2xl walker-secondary text-center my-4">Vous invitent</h2>

            <h3 class="text-2xl font-semibold walker-primary text-center mt-6"> au 100 KM – FAMENNE – ARDENNE</h3>

            <p class="text-lg text-center font-bold">Le vendredi 29 août 2025 - Départ à 21h</p>
            @include('filament.pages.parts._btn_signup')
        </div>

        <h3 class="text-2xl font-semibold walker-primary mt-6"> et aux autres parcours</h3>
        <p class="text-lg ">Le samedi 30 août 2025</p>

        <table class="w-full border-collapse mt-6 max-w-xl">
            <thead>
            <tr class="bg-green-600 text-white">
                <th class="p-2">Distance</th>
                <th class="p-2">Horaire</th>
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

        <h3 class="text-2xl font-semibold walker-secondary mt-6">DÉPART</h3>
        <p class="font-semibold">Le Vendredi 29 août 2025 à 21h</p>
        <p class="font-semibold">Institut Ste Julie</p>
        <p>
            <a href="https://maps.app.goo.gl/NunW5AvTdTgLcK1b7" target="_blank" class="underline">
                Rue de Nérette 2, 6900 – MARCHE-en-FAMENNE
            </a>
        </p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">INSCRIPTION</h3>
        <p>Avant le 1 août 2025 : <span class="font-semibold">45 €</span></p>
        <p>Après le 1 août 2025 : <span class="font-semibold">50 €</span> / Sans T-shirt</p>
        <p class="mt-2">Ce prix comprend : tee-shirt, petit déjeuner à mi-parcours et ravitaillement.</p>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">IMPORTANT</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>L’âge minimum est de 16 ans.</li>
            <li>Une veste fluorescente et une lampe frontale sont obligatoires.</li>
            <li>Le transport des bagages est à mi-parcours.</li>
            <li>Les 100 km doivent être parcourus en maximum 24 h.</li>
            <li>Les ravitaillements sont fournis par l’organisateur.</li>
            <li>La marche aura lieu même si les conditions climatiques sont défavorables.</li>
            <li>L’inscription à la marche vaut un certificat de bonne santé.</li>
        </ul>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">SECRETARIAT</h3>
        <ul class="list-disc pl-6 mt-2">
            <li>Le secrétariat est ouvert le vendredi 29 août 2025 à partir de 17h30.</li>
            <li>La permanence de la FFBMP et IVV le samedi 30 août 2025 de 9 h à 21 h.</li>
        </ul>

        <h3 class="text-2xl font-semibold walker-secondary mt-6">RENSEIGNEMENTS</h3>
        <p>DEGEYE Philippe – <a href="mailto:degeye.philippe@gmail.com" class="text-green-600 underline">degeye.philippe@gmail.com</a>
            – +32 476 545 951</p>

        <div class="my-6">
            <a href="https://marcheursdelafamenne.marche.be" target="_blank"
               class="text-green-600 underline font-semibold">https://marcheursdelafamenne.marche.be</a>
        </div>

        @include('filament.pages.parts._logos')
    </div>

</x-filament-panels::page>
