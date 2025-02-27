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
            <x-seller/>
        </td>
    </tr>
</table>
<table class="table mt-5">
    <tbody>
    <tr>
        <td class="border-0 pl-0" width="50%">
            @include('invoices::pdf.buyer')
        </td>
        <td class="border-0 pl-0">
            <h4 class="text-uppercase cool-gray">
                <strong>{{ $invoice->registration->statusText() }}</strong>
            </h4>
            <p>{{ __('invoices::messages.invoice.serial') }} <strong>{{ $invoice->registration->id }}</strong></p>
            <p>{{ __('invoices::messages.invoice.date') }}:
                <strong>{{ $invoice->registration->registrationDateFormated() }}</strong></p>
        </td>
    </tr>
    </tbody>
</table>

<x-list-walkers :walkers="$invoice->registration->walkers" :amount="$invoice->registration->totalAmountInWords()"/>

@if($invoice->notes)
    <p>
        {{ __('invoices::messages.invoice.notes') }}: {!! $invoice->notes !!}
    </p>
@endif

<p>
    {{ __('invoice.payment.total_amount.label') }}: {{ $invoice->registration->totalAmountInWords() }}
</p>

<h3 class="text-2xl font-semibold walker-primary my-2">
    {{__('invoices::messages.invoice.payment.title')}}
</h3>

<x-payment-information :amount="$invoice->registration->totalAmountInWords()" :communication="$invoice->registration->communication()"/>
@include('invoices::pdf.qrcode')

</body>
</html>
