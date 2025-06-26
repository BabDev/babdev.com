@php /** @var \App\Pagination\RoutableLengthAwarePaginator<\App\Models\PackageUpdate> $updates */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%sOpen Source Updates | %s', (!$updates->onFirstPage() ? sprintf('Page %d | ', $updates->currentPage()) : ''), config('app.name', 'BabDev')),
])

@section('meta')
    <link rel="alternate" type="application/atom+xml" title="BabDev Open Source Package Updates" href="{{ route('feeds.package-updates') }}">
    @unless($updates->onFirstPage())
        <link rel="canonical" href="{!! route('open-source.updates') !!}" />
        <link rel="prev" href="{!! $updates->currentPage() - 1 === 1 ? route('open-source.updates') : $updates->previousPageUrl() !!}" />
        @if($updates->hasMorePages())
            <link rel="next" href="{!! $updates->nextPageUrl() !!}" />
        @endif
    @else
        @if($updates->hasMorePages())
            <link rel="next" href="{!! $updates->nextPageUrl() !!}" />
        @endif
    @endunless
@endsection

@section('content')
    <x-hero title="Open Source Package Updates" />

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                @forelse($updates as $update)
                    <article class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <header class="mb-4">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-orange text-white">
                                        {{ $update->package->display_name }}
                                    </span>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <x-far-calendar class="mr-1 h-4 w-4 fill-current" /> <time datetime="{{ $update->published_at->format('c') }}">{{ $update->published_at->format('F j, Y') }}</time>
                                    </div>
                                </div>

                                <h2 class="text-xl font-semibold text-gray-900 hover:text-brand-orange transition-colors duration-200">
                                    <a href="{{ route('open-source.update', ['update' => $update]) }}">{{ $update->title }}</a>
                                </h2>
                            </header>

                            <div class="package-update-intro">
                                {!! $update->intro !!}
                            </div>

                            <div>
                                <a class="inline-flex items-center text-brand-orange hover:text-orange-700 font-medium transition-colors duration-200" href="{{ route('open-source.update', ['update' => $update]) }}">Read Update <x-fas-chevron-right class="ml-1 h-4 w-4 fill-current" /></a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <x-fas-info-circle class="h-5 w-5 text-blue-400 fill-current" />
                            </div>
                            <div class="ml-3">
                                <div class="text-xl font-semibold text-blue-800">No Updates</div>
                                <p class="mt-1 text-md text-blue-700">Sorry, there are no updates available at this time.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($updates->hasPages())
                <div class="mt-12">
                    {{ $updates->render() }}
                </div>
            @endif

            <div class="mt-6">
                {{ Breadcrumbs::render('open-source.updates') }}
            </div>
        </div>
    </section>
@endsection
