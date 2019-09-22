@php /** @var \BabDev\Models\JoomlaExtension $extension */ @endphp
@php /** @var \BabDev\Models\JoomlaExtensionRelease $release */ @endphp

@extends('layouts.app')

@section('title'){{ $extension->name }} {{ $release->version }} Release | {{ config('app.name', 'Laravel') }}@endsection

@section('content')
    <section class="extension-title pt-4">
        <div class="extension-title__logo">
            <img src="{{ Storage::disk('logos')->url($extension->logo) }}" alt="{{ $extension->name }} Logo">
        </div>
        <div class="extension-title__name">
            <h1 class="extension-title__primary">{{ $extension->name }}</h1>
            <h2 class="extension-title__secondary">{{ $release->version }} Release</h2>
        </div>
    </section>
    <section class="extension-releases pt-2">
        <div class="container">
            @unless($extension->supported)
                <div class="alert alert-warning">
                    <div class="alert-heading">Unsupported Extension</div>
                    <div>The {{ $extension->name }} extension is no longer supported, the releases remain available for download for historical reference.</div>
                </div>
            @endunless
            <div class="release">
                <div class="release__summary">
                    {!! $release->summary !!}
                </div>
                <div class="release__info">
                    <dl>
                        <dt>Maturity</dt>
                        <dd>{{ trans('stability.' . $release->maturity) }}</dd>
                        <dt>Released On</dt>
                        <dd>{{ $release->published_at->format('F j, Y') }}</dd>
                    </dl>
                </div>
            </div>
            {{ Breadcrumbs::render('joomla-extensions.releases.show', $extension, $release) }}
        </div>
    </section>
@endsection
