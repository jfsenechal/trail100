<table class="my-1 text-left">
    <tr>
        <th>{{__('invoices::messages.invoice.payment.for.label')}}</th>
        <td>{{config('app.name')}}</td>
    </tr>
    <tr>
        <th>{{__('invoices::messages.invoice.payment.iban.label')}}</th>
        <td>{{config('invoices.seller.bank_account')}}</td>
    </tr>
    <tr>
        <th>{{__('invoices::messages.invoice.payment.communication.label')}} </th>
        <td>{{$record->communication()}}</td>
    </tr>
    <tr>
        <th>{{__('invoices::messages.invoice.payment.total_amount.label')}}</th>
        <td>{{$record->totalAmountInWords()}}</td>
    </tr>
</table>
