<x-filament-panels::page>

    @include('filament.pages.parts._walkers_list', ['walkers'=>$record->walkers, 'amountInWords'=>$record->totalAmountInWords()])

    <h3 class="text-2xl font-semibold walker-secondary my-2">
        {{__('invoices::messages.invoice.payment.title')}}
    </h3>
    @include('filament.pages.parts._payment_info')

    @include('invoices::pdf.qrcode')

</x-filament-panels::page>
