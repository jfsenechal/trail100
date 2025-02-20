<x-mail::message>
# Welcome {{$registration->email}}

##{{ config('app.name') }}

## Votre inscription sera validée après paiement

<x-mail::table>
| Name          | T-shirt       | Price         |
| ------------- | :-----------: | ------------: |
@foreach($registration->walkers as $item)
| {{$item->name()}} | {{$item->tshirt_size}} | {{$item->amount()}} |
@endforeach
</x-mail::table>
---
## Informations de paiements

@if(isset($logo))
![Image](cid:image.png)
<img src="{{$message->embed($logo)}}" alt="logo" height="100">
@else
    <p>Image not found.</p>
@endif

<x-mail::button :url="$url" color="success">
    {{$textbtn}}
</x-mail::button>
<x-mail::panel>
    <p>coucou</p>
</x-mail::panel>
[Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)
<x-mail::subcopy>
    Ma subcopy
</x-mail::subcopy>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
