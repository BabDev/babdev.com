@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var string $version */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s Documentation | %s', $package->display_name, config('app.name', 'BabDev')),
])

@section('content')
    <x-package-title :package="$package" secondary-title="Documentation" class="pt-4" />
    <article class="pt-4">
        <div class="container package-docs package-docs--version-not-found">
            <div class="package-docs__content">
                <div class="package-docs__version-not-found-alert alert alert-warning">
                    <div class="alert-heading">Version Documentation Not Found</div>
                    <p>Sorry, the documentation for version "{{ $version }}" was not found. Using the links below, you can navigate to the documentation for each supported version of this package.</p>
                </div>

                <ul class="nav justify-content-center my-4">
                    @foreach($package->versions as $packageVersion)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('open-source.packages.package-docs-page', ['package' => $package, 'version' => $packageVersion->version, 'slug' => 'intro']) }}">{{ $packageVersion->version }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="container">
            {{ Breadcrumbs::render('open-source.packages.package-docs-page', $package, null, 'Version Not Found') }}
        </div>
    </article>
@endsection

@section('bodyScripts')
    <script src="{{ PushManager::preload(mix('js/docs.js'), ['as' => 'script', 'integrity' => Sri::hash('js/docs.js'), 'crossorigin' => 'anonymous']) }}" {{ Sri::html('js/docs.js') }}></script>
@endsection
