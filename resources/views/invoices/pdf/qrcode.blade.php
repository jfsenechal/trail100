
@if(isset($qrCode))
    <table style="position: relative;right: 5px;top:50px;width: 90%; margin-bottom: 4rem;">
        <tr>
            <td style="width:30%;text-align: center;">
                <img src="{{ $qrCodeScanning }}"
                     widt2h="150" alt="scan"  style="width:80%;"/>
            </td>
            <td style="width:40%;text-align: center;">
                <h3>{{__('invoices::messages.invoice.payment.easy')}}</h3>
                <p>
                    {{__('invoices::messages.invoice.payment.help')}}
                </p>
            </td>
            <td style="width:30%;text-align: center;">
                <img src="{{$qrCode}}" alt="qrcode"  style="width:80%;">
            </td>
        </tr>
    </table>
@endif
