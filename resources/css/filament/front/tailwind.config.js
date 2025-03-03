import preset from '../../../../vendor/filament/filament/tailwind.config.preset'
// https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss
export default {
    presets: [preset],
    content: [
        './app/Filament/FrontPanel/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            objectPosition: {
                "top-center": "top center",
            },
        },
    },
}
