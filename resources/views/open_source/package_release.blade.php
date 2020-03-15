@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var \BabDev\Models\PackageRelease $release */ @endphp

@extends('layouts.app')

@section('title', sprintf('%s %s Release | %s', $package->display_name, $package->version, config('app.name', 'Laravel')))

@section('content')
    <section class="package-title{{ $package->logo ? ' package-title--has-logo' : '' }} pt-4">
        @if($package->logo)
            <div class="package-title__logo">
                <img src="{{ Storage::disk('logos')->url($package->logo) }}" alt="{{ $package->display_name }} Logo">
            </div>
        @endif
        <div class="package-title__name">
            <h1 class="package-title__primary">{{ $package->display_name }}</h1>
            <h2 class="package-title__secondary">{{ $release->version }} Release</h2>
        </div>
    </section>
    <section class="package-releases container pt-2">
        @unless($package->supported)
            <div class="package-releases__unsupported-package alert alert-warning">
                <div class="alert-heading">Unsupported Extension</div>
                <div>The {{ $package->display_name }} extension is no longer supported, the releases remain available for download for historical reference.</div>
            </div>
        @endunless
        <div class="package-release">
            <div class="package-release__summary">
                {!! $release->summary !!}
            </div>
            <div class="package-release__info">
                <dl>
                    <dt>Maturity</dt>
                    <dd>{{ trans('stability.' . $release->maturity) }}</dd>
                    <dt>Released On</dt>
                    <dd>{{ $release->released_at->format('F j, Y') }}</dd>
                </dl>
            </div>
        </div>
        {{ Breadcrumbs::render('open-source.package.release', $package, $release) }}
    </section>
@endsection
