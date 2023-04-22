@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var string|null $secondaryTitle */ @endphp

<header {{ $attributes->merge(['class' => 'package-title']) }}>
    <div class="package-title__name">
        <h1 class="package-title__primary">{{ $package->display_name }}</h1>
        @if($secondaryTitle)
            <h2 class="package-title__secondary">{{ $secondaryTitle }}</h2>
        @endif
    </div>
</header>
