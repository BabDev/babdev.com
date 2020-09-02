@php /** @var string $title */ @endphp
@php /** @var string|null $subtitle */ @endphp
@php /** @var string[] $modifiers */ @endphp

<section {{ $attributes->merge(['class' => 'hero']) }}>
    <div class="hero__text">
        <h1 class="hero__title">{{ $title }}</h1>
        @if($subtitle)
            <h2 class="hero__subtitle">{{ $subtitle }}</h2>
        @endif
    </div>
</section>
