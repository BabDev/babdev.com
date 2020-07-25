@php /** @var \BabDev\Models\PackageUpdate $update */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s | Open Source Updates | %s', $update->title, config('app.name', 'BabDev')),
    'ogTitle' => sprintf('%s | %s', $update->title, config('app.name', 'BabDev')),
    'ogType' => 'article',
])

@section('meta')
    <meta property="article:published_time" content="{{ $update->published_at->format('c') }}" />
    <meta property="article:modified_time" content="{{ $update->updated_at->format('c') }}" />
@endsection

@section('content')
    <header class="package-title{{ $update->package->logo ? ' package-title--has-logo' : '' }} pt-4">
        @if($update->package->logo)
            <div class="package-title__logo">
                <img src="{{ Storage::disk('logos')->url($update->package->logo) }}" alt="{{ $update->package->display_name }} Logo">
            </div>
        @endif
        <div class="package-title__name">
            <h1 class="package-title__primary">{{ $update->package->display_name }}</h1>
            <h2 class="package-title__secondary">Package Update</h2>
        </div>
    </header>
    <article class="pt-4">
        <div class="container package-update">
            <header class="section-heading">
                <h2>{{ $update->title }}</h2>
            </header>
            <div class="item-published">
                <span class="item-published__icon">{{ svg('far-calendar') }}</span>
                <span class="item-published__date">{{ $update->published_at->format('F j, Y') }}</span>
            </div>
            <div class="package-update__content">
                {!! $update->content !!}
            </div>
            {{ Breadcrumbs::render('open-source.update', $update) }}
        </div>
    </article>
@endsection

@section('bodyScripts')
    <script src="{{ PushManager::preload(mix('js/updates.js'), ['as' => 'script']) }}"></script>
@endsection
