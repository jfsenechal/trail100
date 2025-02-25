<x-mail::message>

@if(isset($logo))
<img src="{{$message->embed($logo)}}" alt="logo" height="100" style="float: left;">
@else
<p>Image not found.</p>
@endif

# {{ config('app.name') }}

## Welcome {{$registration->firstWalker->first_name}} {{$registration->firstWalker->last_name}} :joy:

<x-mail::panel style="margin-top: 20px;margin-bottom: 20px;">
<p style="color: #9f1239;font-weight: bold;">
## {{__('invoices::messages.form.registration.notification.finish.body')}}
</p>
</x-mail::panel>

## {{__('invoices::messages.invoice.payment.title')}}
@include('mail._payment_info_markdown', ['record' => $registration])

## {{__('invoices::messages.walkers')}}

<x-mail::table>
| ##{{__('invoices::messages.last_name')}}  | ## {{__('invoices::messages.tshirt_size')}}  | ## {{__('invoices::messages.invoice.price')}}  |
| -------- | -------- | -------|
@foreach($registration->walkers as $item)
| {{$item->name()}} | {{$item->tshirt_size}} | {{$item->amountInWords()}} |
@endforeach
</x-mail::table>
---

<x-mail::button :url="$url" color="success">
    {{$textbtn}}
</x-mail::button>

@if(isset($qrcode))
<img src="{{$message->embed($qrcode)}}" alt="logo" height="200">
@else
<p>qrcode not found.</p>
@endif

[Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)

<x-mail::subcopy>
    Ma subcopy
</x-mail::subcopy>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
