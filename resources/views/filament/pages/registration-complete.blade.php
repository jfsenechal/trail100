<div class="mx-5 bg-white shadow-lg rounded-lg p-4">
    <div class="flex flex-row items-center justify-center">
        <img src={{asset('images/'}}logoMarcheur.jpg" alt="logo marcheur" class="w-56 ml-8">
        <h1 class="text-3xl font-bold walker-primary text-center">
            {{__('invoices::messages.form.registration.notification.finish.title')}}
        </h1>
    </div>

    <h3 class="text-2xl font-semibold walker-primary my-2">{{__('invoices::invoice.for.title')}}</h3>

    @include('filament.pages.parts._walkers_list', ['walkers'=>$registration->walkers, 'amountInWords'=>$registration->totalAmountInWords()])

    @include('filament.pages.parts._payment_info')

    @include('invoices::pdf.qrcode')

</div>
