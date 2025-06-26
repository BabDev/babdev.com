@php /** @var \App\Models\PackageUpdate $update */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s | Open Source Updates | %s', $update->title, config('app.name', 'BabDev')),
    'ogTitle' => sprintf('%s | %s', $update->title, config('app.name', 'BabDev')),
    'ogType' => 'article',
])

@section('meta')
    <meta property="article:published_time" content="{{ $update->published_at->format('c') }}" />
    <meta property="article:modified_time" content="{{ $update->updated_at->format('c') }}" />
@endsection

@section('assets')
    @vite(['resources/js/updates.js'])
@endsection

@section('content')
    <x-hero :title="$update->package->display_name" subtitle="Package Update" />

    <article class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">
                    {{ $update->title }}
                </h1>

                <div class="flex items-center text-sm text-gray-500">
                    <x-far-calendar class="mr-1 h-4 w-4 fill-current" /> <time datetime="{{ $update->published_at->format('c') }}">{{ $update->published_at->format('F j, Y') }}</time>
                </div>
            </header>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="p-8">
                    <div class="package-update-content">
                        {!! $update->content !!}
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between">
                <a class="inline-flex items-center text-brand-orange hover:text-orange-700 transition-colors duration-200" href="{{ route('open-source.updates') }}">
                    <x-fas-chevron-left class="mr-2 h-4 w-4 fill-current" /> Back to All Updates
                </a>

                @if($update->package->has_documentation)
                    <a class="inline-flex items-center rounded-md bg-brand-orange px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition-colors duration-200" href="{{ route('open-source.packages.package-docs-page', ['package' => $update->package, 'version' => $update->package->latestVersion()->version, 'slug' => 'intro']) }}">
                        View Documentation <x-far-file-lines class="ml-2 h-4 w-4 fill-current" />
                    </a>
                @endif
            </div>

            <div class="mt-6">
                {{ Breadcrumbs::render('open-source.update', $update) }}
            </div>
        </div>
    </article>
@endsection
