@php /** @var \Illuminate\Database\Eloquent\Collection<\BabDev\Models\Package> $packages */ @endphp

@extends('layouts.app', [
    'title' => sprintf('Open Source Packages | %s', config('app.name', 'BabDev')),
])

@section('content')
    <x-hero title="Open Source Packages" />
    <section class="pt-4">
        <div class="container">
            @forelse($packages as $package)
                <div @class(['open-source-package', 'open-source-package--has-topics' => !empty($package->topics), 'open-source-package--has-links' => $package->has_documentation, 'open-source-package--abandoned' => !$package->supported, 'mb-3'])>
                    <div class="open-source-package__name section-heading">
                        <a class="open-source-package__link" href="{{ $package->github_url }}" target="_blank" rel="nofollow noreferrer noopener" aria-label="View {{ $package->display_name }} on GitHub">
                            {{ resource_svg('fab-github') }}
                        </a>
                        <h2>{{ $package->display_name }}</h2>
                    </div>
                    <div class="open-source-package__description">
                        {{ $package->description }}
                    </div>
                    <div class="open-source-package__statistics package-statistics mt-2">
                        @if(!$package->supported)
                            <span class="package-statistic package-statistic--unsupported">Package Not Supported</span>
                        @endif
                        <span class="package-statistic package-statistic--language">{{ $package->language }}</span>
                        @if($package->package_type)
                            <span class="package-statistic package-statistic--package-type package-statistic--package-type--{{ $package->package_type->value }}">{{ trans('package_type.'.$package->package_type->value) }}</span>
                        @endif
                        @if($package->downloads)
                            <span class="package-statistic package-statistic--downloads">
                                <span class="package-statistic__value">{{ number_format($package->downloads) }}</span>
                                <span class="package-statistic__icon">{{ resource_svg('fas-download') }}</span>
                            </span>
                        @endif
                        @if($package->stars)
                            <span class="package-statistic package-statistic--stars">
                                <span class="package-statistic__value">{{ $package->stars }}</span>
                                <span class="package-statistic__icon">{{ resource_svg('far-star') }}</span>
                            </span>
                        @endif
                    </div>
                    @unless(empty($package->topics))
                        <div class="open-source-package__topics package-topics mt-2">
                            @foreach($package->topics as $topic)
                                <span class="package-topic">{{ $topic }}</span>
                            @endforeach
                        </div>
                    @endunless
                    @if($package->has_documentation)
                        <div class="open-source-package__links package-links mt-2">
                            <span class="package-link">
                                <a class="btn btn-brand" href="{{ route('open-source.packages.package-docs-page', ['package' => $package, 'version' => $package->latestVersion()->version, 'slug' => 'intro']) }}">View Documentation</a>
                            </span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="alert alert-info">
                    <div class="alert-heading">No Packages</div>
                    <div>Sorry, there are no packages available at this time.</div>
                </div>
            @endforelse
            {{ Breadcrumbs::render('open-source.packages') }}
        </div>
    </section>
@endsection
