
**{{__('invoices::messages.invoice.payment.for.label')}}:** {{config('app.name')}}

**{{__('invoices::messages.invoice.payment.iban.label')}}:**  {{config('invoices.seller.bank_account')}}

**{{__('invoices::messages.invoice.payment.communication.label')}}:** {{$record->communication()}}

**{{__('invoices::messages.invoice.payment.total_amount.label')}}:** {{$record->totalAmountInWords()}}
