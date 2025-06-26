@php /** @var string $title */ @endphp
@php /** @var string|null $subtitle */ @endphp

<section {{ $attributes->merge(['class' => 'relative bg-gradient-to-br from-brand-orange to-orange-600 overflow-hidden']) }}>
    <div class="absolute inset-0 bg-black/20"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-18">
        <div class="text-center">
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-4xl">{{ $title }}</h1>
            @if($subtitle)
                <h2 class="mt-6 text-lg leading-8 text-orange-100 sm:text-xl lg:text-2xl">{{ $subtitle }}</h2>
            @endif
        </div>
    </div>
</section>
