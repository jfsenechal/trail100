
@if(isset($qrCode))
    <table style="position: relative;right: 5px;top:50px;width: 90%; margin: auto;">
        <tr>
            <td style="width:25%;">
                <img src="{{ $qrCodeScanning }}"
                     width="150" alt="scan"/>
            </td>
            <td style="width:35%;text-align: center;">
                <h3>{{__('invoices::messages.invoice.payment.easy')}}</h3>
                <p>
                    {{__('invoices::messages.invoice.payment.help')}}
                </p>
            </td>
            <td style="width:30%;">
                <img src="{{$qrCode}}" alt="qrcode" height="180" width="180">
            </td>
        </tr>
    </table>
@endif
