@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var \BabDev\Models\PackageVersion $package_version */ @endphp
@php /** @var string $contents */ @endphp
@php /** @var string $sidebar */ @endphp
@php /** @var string|null $title */ @endphp
@php /** @var string $version */ @endphp
@php /** @var string $slug */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s%s %s Documentation | %s', ($title !== null ? ($title . ' | ') : ''), $package->display_name, $version, config('app.name', 'BabDev')),
])

@section('content')
    <x-package-title :package="$package" secondary-title="Documentation" class="pt-4" />
    <article class="pt-4">
        <div class="container-fluid package-docs">
            <div class="package-docs__sidebar">
                @if($package->versions->count() > 1)
                    <div class="package-docs__version-selector dropdown">
                        <a class="btn btn-light dropdown-toggle" href="#" role="button" id="docs-version-selector" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Version ({{ $version }})
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="docs-version-selector">
                            @foreach($package->versions as $availablePackageVersion)
                                <li><a @class(['dropdown-item', 'active' => $availablePackageVersion->version === $version]) href="{{ route('open-source.packages.package-docs-page', ['package' => $package, 'version' => $availablePackageVersion->version, 'slug' => $slug]) }}">{{ $availablePackageVersion->version }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-markdown flavor="github">{!! $sidebar !!}</x-markdown>
            </div>
            <x-markdown class="package-docs__content" flavor="github">{!! $contents !!}</x-markdown>
        </div>
        <div class="container">
            {{ Breadcrumbs::render('open-source.packages.package-docs-page', $package, $title) }}
        </div>
    </article>
@endsection

@section('bodyScripts')
    <script src="{{ PushManager::preload(mix('js/docs.js'), ['as' => 'script', 'integrity' => Sri::hash('js/docs.js'), 'crossorigin' => 'anonymous']) }}" {{ Sri::html('js/docs.js') }}></script>
@endsection
