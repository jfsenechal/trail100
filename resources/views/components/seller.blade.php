<div>
    @if($name)
        <p class="seller-name">
            <strong>{{ $name }}</strong>
        </p>
    @endif

    @if($address)
        <p class="seller-address">
            {{ __('invoices::messages.invoice.address') }}: {{ $address }} {{$code}} {{$city}}
        </p>
    @endif

    @if($bank_account)
        <p class="seller-vat">
            {{ __('invoices::messages.invoice.iban') }}: {{ $bank_account }}
        </p>
    @endif

    @if($phone)
        <p class="seller-phone">
            {{ __('invoices::messages.invoice.phone') }}: {{ $phone }}
        </p>
    @endif
</div>
