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
    <x-hero :title="$update->package->display_name" subtitle="Package Update" />
    <article class="pt-4">
        <div class="container package-update">
            <header class="section-heading">
                <h2>{{ $update->title }}</h2>
            </header>
            <div class="item-published">
                <span class="item-published__icon">{{ resource_svg('far-calendar') }}</span>
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
    @vite(['resources/js/updates.js'])
@endsection
