<div class="flex flex-row gap-2 items-center justify-center my-4">
    <a href="/change-language/en" class="block w-6 {{ app()->currentLocale() == 'en' ? 'lng-selected' : '' }}"
    title="in English">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40">
            <rect width="60" height="40" fill="white"/>
            <rect x="25" width="10" height="40" fill="red"/>
            <rect y="15" width="60" height="10" fill="red"/>
        </svg>
    </a>
    <a href="/change-language/fr" class="block w-6 {{ app()->currentLocale() == 'fr' ? 'lng-selected' : '' }}"
    title="en français">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40">
            <rect width="20" height="40" fill="blue"/>
            <rect x="20" width="20" height="40" fill="white"/>
            <rect x="40" width="20" height="40" fill="red"/>
        </svg>
    </a>
    <a href="/change-language/nl" class="block w-6 {{ app()->currentLocale() == 'nl' ? 'lng-selected' : '' }}"
    title="in het Nederlands">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40">
            <rect width="60" height="40" fill="red"/>
            <rect y="13.33" width="60" height="13.33" fill="white"/>
            <rect y="26.66" width="60" height="13.33" fill="blue"/>
        </svg>
    </a>
    <a href="/change-language/de" class="block w-6 {{ app()->currentLocale() == 'de' ? 'lng-selected' : '' }}"
    title="auf Deutsch">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40">
            <rect width="60" height="13.33" fill="black"/>
            <rect y="13.33" width="60" height="13.33" fill="red"/>
            <rect y="26.66" width="60" height="13.33" fill="gold"/>
        </svg>
    </a>
</div>
