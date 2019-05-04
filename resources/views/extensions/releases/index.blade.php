@php /** @var \BabDev\Models\JoomlaExtension $extension */ @endphp
@php /** @var \Illuminate\Database\Eloquent\Collection|\BabDev\Models\JoomlaExtensionRelease[] $releases */ @endphp

@extends('layouts.app')

@section('title'){{ $extension->name }} Releases | {{ config('app.name', 'Laravel') }}@endsection

@section('content')
    <section class="extension-title pt-4">
        <div class="extension-title__logo">
            <img src="{{ Storage::disk('logos')->url($extension->logo) }}" alt="{{ $extension->name }} Logo">
        </div>
        <div class="extension-title__name">
            <h1 class="extension-title__primary">{{ $extension->name }}</h1>
            <h2 class="extension-title__secondary">Releases</h2>
        </div>
    </section>
    <section class="extension-releases pt-2">
        <div class="container">
            @forelse($releases as $release)
                <div class="release">
                    <div class="release__version">
                        <h2>{{ $release->version }}</h2>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <div class="alert-heading">No Releases</div>
                    <div>Sorry, there are no releases of {{ $extension->name }} available at this time.</div>
                </div>
            @endforelse
            {{ Breadcrumbs::render('joomla-extensions.releases.index', $extension) }}
        </div>
    </section>
@endsection
