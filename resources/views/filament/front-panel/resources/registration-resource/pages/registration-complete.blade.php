<x-filament-panels::page>

    <x-alert type="success">
        Merci pour votre inscription

    </x-alert>

    <x-list-walkers :walkers="$record->walkers" :amount="$record->totalAmountInWords()"/>

    <h3 class="text-2xl font-semibold walker-secondary my-2">
        {{__('invoices::messages.invoice.payment.title')}}
    </h3>

    <x-payment-information :amount="$record->totalAmountInWords()" :communication="$record->communication()"/>

    @include('invoices::pdf.qrcode')
</x-filament-panels::page>
