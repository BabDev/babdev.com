@php /** @var \BabDev\Pagination\RoutableLengthAwarePaginator|\BabDev\Models\PackageUpdates[] $updates */ @endphp

@extends('layouts.app')

@section('title', sprintf('Open Source Package Updates | %s', config('app.name', 'Laravel')))

@section('content')
    <header class="hero hero--open-source-package-updates">
        <div class="hero__text">
            <h1 class="hero__title">Open Source Package Updates</h1>
        </div>
    </header>
    <section class="open-source-package-updates pt-4">
        <div class="container">
            @forelse($updates as $update)
                <article class="open-source-package-update">
                    <header class="open-source-package-update__title">
                        <h2>{{ $update->title }}</h2>
                    </header>
                    <div class="open-source-package-update__teaser">
                        {!! $update->intro !!}
                    </div>
                </article>
            @empty
                <div class="alert alert-info">
                    <div class="alert-heading">No Updates</div>
                    <div>Sorry, there are no updates available at this time.</div>
                </div>
            @endforelse
            {{ $updates->render() }}
            {{ Breadcrumbs::render('open-source.updates') }}
        </div>
    </section>
@endsection
