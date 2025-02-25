<table class="table">
    <tbody>
    <tr>
        <td class="px-0">
            @if($invoice->buyer->name)
                <p class="buyer-name">
                    <strong>{{ $invoice->buyer->name }}</strong>
                </p>
            @endif

            @if($invoice->buyer->address)
                <p class="buyer-address">
                    {{ __('invoices::messages.invoice.address') }}: {{ $invoice->buyer->address }}
                </p>
            @endif

            @if($invoice->buyer->city)
                <p class="buyer-code">
                    {{ __('invoices::messages.invoice.city') }}: {{ $invoice->buyer->city }}
                </p>
            @endif

            @if($invoice->buyer->phone)
                <p class="buyer-phone">
                    {{ __('invoices::messages.invoice.phone') }}: {{ $invoice->buyer->phone }}
                </p>
            @endif
        </td>
    </tr>
    </tbody>
</table>
