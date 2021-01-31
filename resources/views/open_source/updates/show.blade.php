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
    <x-package-title :package="$update->package" secondary-title="Package Update" class="pt-4" />
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
    <script src="{{ PushManager::preload(mix('js/updates.js'), ['as' => 'script', 'integrity' => Sri::hash('js/updates.js'), 'crossorigin' => 'anonymous']) }}" integrity="{{ Sri::hash('js/updates.js') }}" crossorigin="anonymous"></script>
@endsection
