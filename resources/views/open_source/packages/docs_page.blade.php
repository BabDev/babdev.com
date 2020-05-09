@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var string $page */ @endphp
@php /** @var string $sidebar */ @endphp
@php /** @var string|null $title */ @endphp

@extends('layouts.app')

@section('title', sprintf('%s%s Documentation | %s', ($title !== null ? ($title . ' | ') : ''), $package->display_name, config('app.name', 'Laravel')))

@section('content')
    <header class="package-title{{ $package->logo ? ' package-title--has-logo' : '' }} pt-4">
        @if($package->logo)
            <div class="package-title__logo">
                <img src="{{ Storage::disk('logos')->url($package->logo) }}" alt="{{ $package->display_name }} Logo">
            </div>
        @endif
        <div class="package-title__name">
            <h1 class="package-title__primary">{{ $package->display_name }}</h1>
            <h2 class="package-title__secondary">Documentation</h2>
        </div>
    </header>
    <article class="pt-4">
        <div class="container-fluid package-docs">
            <aside class="package-docs__sidebar">
                {!! $sidebar !!}
            </aside>
            <div class="package-docs__content">
                {!! $page !!}
            </div>
        </div>
        <div class="container">
            {{ Breadcrumbs::render('open-source.packages.package-docs-page', $package, $title) }}
        </div>
    </article>
@endsection

@section('bodyScripts')
    <script src="{{ PushManager::preload(mix('js/docs.js'), ['as' => 'script']) }}"></script>
@endsection
