<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4, .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4, .h4 {
            font-size: 1.2rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
{{-- Header --}}
<table style="width: 100%;margin-left: 50px;margin-right: 50px;">
    <tr>
        <td style="width: 50%;">
            @if(isset($invoice->logo))
                <img src="{{$invoice->logo}}" alt="logo" height="100">
            @else
                <p>Image not found.</p>
            @endif
        </td>
        <td style="width: 50%;">
            @include('invoices::pdf.sender')
        </td>
    </tr>
</table>
<table class="table mt-5">
    <tbody>
    <tr>
        <td class="border-0 pl-0" width="70%">
            @include('invoices::pdf.buyer')
        </td>
        <td class="border-0 pl-0">
            @if($invoice->status)
                <h4 class="text-uppercase cool-gray">
                    <strong>{{ $invoice->status }}</strong>
                </h4>
            @endif
            <p>{{ __('invoices::invoice.serial') }} <strong>{{ $invoice->id }}</strong></p>
            <p>{{ __('invoices::invoice.date') }}: <strong>{{ $invoice->date }}</strong></p>
        </td>
    </tr>
    </tbody>
</table>

{{-- Buyer --}}

{{-- Table --}}
<table class="table table-items">
    <thead>
    <tr>
        <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
        <th scope="col" class="text-center border-0">{{ __('invoices::invoice.quantity') }}</th>
        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.price') }}</th>
        <th scope="col" class="text-right border-0 pr-0">{{ __('invoices::invoice.sub_total') }}</th>
    </tr>
    </thead>
    <tbody>
    {{-- Items --}}
    @foreach($invoice->items as $item)
        <tr>
            <td class="pl-0">
                {{ $item->first_name }}{{ $item->last_name }}
                @if($item->city)
                    <p class="cool-gray">{{ $item->city }}</p>
                @endif
            </td>
            <td class="text-center">{{ $item->tshirt_size->value }}</td>
            <td class="text-right">
                {{ $invoice->formatCurrency($item->amount()) }}
            </td>
            <td class="text-right pr-0">
                {{ $invoice->formatCurrency($item->amount()) }}
            </td>
        </tr>
    @endforeach
    {{-- Summary --}}
    <tr>
        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
        <td class="text-right pl-0">{{ __('invoices::invoice.total_amount') }}</td>
        <td class="text-right pr-0 total-amount">
            {{ $invoice->formatCurrency($invoice->total_amount) }}
        </td>
    </tr>
    </tbody>
</table>

@if($invoice->notes)
    <p>
        {{ __('invoices::invoice.notes') }}: {!! $invoice->notes !!}
    </p>
@endif

<p>
    {{ __('invoices::invoice.amount_in_words') }}: {{ $invoice->getTotalAmountInWords() }}
</p>
<p>
    {{ __('invoices::invoice.pay_until') }}: blabla
</p>

<h3>Informations de paiements</h3>
<br/>
<strong>For : </strong> {{config('app.name')}}
<br/>
<strong>IBAN :</strong> {{config('invoices.seller.bank_account')}}
<br/>
<strong>Communication :</strong> {{$invoice->communication}}
<br/>
<strong>Amount : </strong> {{$invoice->getTotalAmountInWords()}} euros

@include('invoices::pdf.qrcode')

</body>
</html>
