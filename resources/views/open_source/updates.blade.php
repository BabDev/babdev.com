@php /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator|\BabDev\Models\PackageUpdates[] $updates */ @endphp

@extends('layouts.app')

@section('title', sprintf('Open Source Package Updates | %s', config('app.name', 'Laravel')))

@section('content')
    <section class="hero hero--open-source-package-updates">
        <div class="hero__text">
            <h1 class="hero__title">Open Source Package Updates</h1>
        </div>
    </section>
    <section class="open-source-package-updates pt-4">
        <div class="container">
            @forelse($updates as $update)
                <div class="open-source-package-update">
                    <div class="open-source-package-update__title">
                        <h2>{{ $update->title }}</h2>
                    </div>
                    <div class="open-source-package-update__teaser">
                        {!! $update->intro !!}
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <div class="alert-heading">No Updates</div>
                    <div>Sorry, there are no updates available at this time.</div>
                </div>
            @endforelse
            {{ Breadcrumbs::render('open-source.updates') }}
        </div>
    </section>
@endsection
