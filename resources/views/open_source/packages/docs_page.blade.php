@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var string $contents */ @endphp
@php /** @var string $sidebar */ @endphp
@php /** @var string|null $title */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s%s Documentation | %s', ($title !== null ? ($title . ' | ') : ''), $package->display_name, config('app.name', 'BabDev')),
])

@section('content')
    <x-package-title :package="$package" secondary-title="Documentation" class="pt-4" />
    <article class="pt-4">
        <div class="container-fluid package-docs">
            <x-markdown class="package-docs__sidebar">{!! $sidebar !!}</x-markdown>
            <x-markdown class="package-docs__content">{!! $contents !!}</x-markdown>
        </div>
        <div class="container">
            {{ Breadcrumbs::render('open-source.packages.package-docs-page', $package, $title) }}
        </div>
    </article>
@endsection

@section('bodyScripts')
    <script src="{{ PushManager::preload(mix('js/docs.js'), ['as' => 'script']) }}"></script>
@endsection
