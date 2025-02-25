<x-filament::button
    href="{{$this->getUrlCreate()}}"
    tag="a"
    badgeSize="xl"
    iconSize="xl"
    outlined="true"
    size="ActionSize::ExtraLarge"
    icon="tabler-sign-right-f"
    class="text-center my-5 text-3xl hover:bg-pink-200"
>
    {{__('invoices::messages.registration.btn.new.signup')}}
</x-filament::button>
