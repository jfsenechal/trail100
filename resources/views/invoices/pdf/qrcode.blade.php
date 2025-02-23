@if(isset($qrCode))
    <table style="position: relative;right: 5px;top:50px;width: 90%; margin: auto;">
        <tr>
            <td style="width:25%;">
                <img src="{{ $qrCodeScanning }}"
                     width="150" alt="scan"/>
            </td>
            <td style="width:35%;text-align: center;">
                <h3>Payer facilement !</h3>
                <p>
                    Scannez ce code via l'application <br> bancaire de votre smartphone et <br>payez facilement
                    en toute sécurité.
                </p>
            </td>
            <td style="width:30%;">
                <img src="{{$qrCode}}" alt="qrcode" height="180" width="180">
            </td>
        </tr>
    </table>
@endif
