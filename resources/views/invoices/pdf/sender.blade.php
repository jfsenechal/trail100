@if($invoice->seller->name)
    <p class="seller-name">
        <strong>{{ $invoice->seller->name }}</strong>
    </p>
@endif

@if($invoice->seller->address)
    <p class="seller-address">
        {{ __('invoices::messages.invoice.address') }}: {{ $invoice->seller->address }}
    </p>
@endif

@if($invoice->seller->bank_account)
    <p class="seller-vat">
        {{ __('invoices::messages.invoice.iban') }}: {{ $invoice->seller->bank_account }}
    </p>
@endif

@if($invoice->seller->phone)
    <p class="seller-phone">
        {{ __('invoices::messages.invoice.phone') }}: {{ $invoice->seller->phone }}
    </p>
@endif
