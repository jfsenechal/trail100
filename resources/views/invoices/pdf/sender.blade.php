@if($invoice->seller->name)
    <p class="seller-name">
        <strong>{{ $invoice->seller->name }}</strong>
    </p>
@endif

@if($invoice->seller->address)
    <p class="seller-address">
        {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
    </p>
@endif

@if($invoice->seller->code)
    <p class="seller-code">
        {{ __('invoices::invoice.code') }}: {{ $invoice->seller->code }} {{ $invoice->seller->city }}
    </p>
@endif
@if($invoice->seller->bank_account)
    <p class="seller-vat">
        {{ __('invoices::invoice.vat') }}: {{ $invoice->seller->bank_account }}
    </p>
@endif

@if($invoice->seller->phone)
    <p class="seller-phone">
        {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
    </p>
@endif
