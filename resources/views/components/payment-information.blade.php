<table class="my-1 text-left">
    <tr>
        <th>{{__('invoices::messages.invoice.payment.for.label')}}</th>
        <td>{{$for}}</td>
    </tr>
    <tr>
        <th>{{__('invoices::messages.invoice.payment.iban.label')}}</th>
        <td>{{$bankAccount}}</td>
    </tr>
    <tr>
        <th>{{__('invoices::messages.invoice.payment.communication.label')}} </th>
        <td>{{$communication}}</td>
    </tr>
    <tr>
        <th>{{__('invoices::messages.invoice.payment.total_amount.label')}}</th>
        <td>{{$amount}}</td>
    </tr>
</table>
