@php /** @var \App\Models\Package $package */ @endphp
@php /** @var string $version */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s Documentation | %s', $package->display_name, config('app.name', 'BabDev')),
])

@section('content')
    <x-hero :title="$package->display_name" subtitle="Documentation" />

    <article class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mb-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex justify-center mb-4">
                        <x-fas-exclamation-triangle class="h-12 w-12 text-yellow-400 fill-current" />
                    </div>
                    <div class="text-xl font-semibold text-yellow-800 mb-2">Version Documentation Not Found</div>
                    <p class="text-yellow-700">Sorry, the documentation for version "{{ $version }}" was not found. Using the links below, you can navigate to the documentation for each supported version of this package.</p>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="text-lg font-medium text-gray-900 mb-6">Available Documentation Versions</div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($package->versions as $packageVersion)
                            <a href="{{ route('open-source.packages.package-docs-page', ['package' => $package, 'version' => $packageVersion->version, 'slug' => 'intro']) }}"
                               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-brand-orange hover:text-brand-orange transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-orange">
                                {{ $packageVersion->version }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8">
                    <a class="inline-flex items-center text-brand-orange hover:text-orange-700 transition-colors duration-200" href="{{ route('open-source.packages') }}">
                        <x-fas-chevron-left class="mr-2 h-4 w-4 fill-current" /> Back to All Packages
                    </a>
                </div>
            </div>
        </div>
    </article>
@endsection
