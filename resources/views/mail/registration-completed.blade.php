<x-mail::message>

@if(isset($logo))
<img src="{{$message->embed($logo)}}" alt="logo" height="100" style="float: left;">
@else
<p>Image not found.</p>
@endif

# {{ config('app.name') }}

## Welcome :joy:

<x-mail::panel style="margin-top: 20px;margin-bottom: 20px;">
<p style="color: #9f1239;font-weight: bold;">
## Votre inscription sera validée après paiement !
</p>
</x-mail::panel>

## Informations de paiements

**Name:** {{config('app.name')}}

**Bank account:** {{config('invoices.bank_account')}}

**Communication:** {{$registration->communication()}}

**Amount:** {{$registration->totalAmount()}} euros


## Walkers

<x-mail::table>
| Name     | T-shirt  | Price  |
| -------- | -------- | -------|
@foreach($registration->walkers as $item)
| {{$item->name()}} | {{$item->tshirt_size}} | {{$item->amount()}} € |
@endforeach
</x-mail::table>
---

<x-mail::button :url="$url" color="success">
    {{$textbtn}}
</x-mail::button>

[Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)

<x-mail::subcopy>
    Ma subcopy
</x-mail::subcopy>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
