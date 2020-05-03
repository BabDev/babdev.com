@php /** @var \BabDev\Pagination\RoutableLengthAwarePaginator|\BabDev\Models\PackageUpdate[] $updates */ @endphp

@extends('layouts.app')

@section('title', sprintf('Open Source Updates | %s', config('app.name', 'Laravel')))

@section('content')
    <header class="hero hero--open-source-package-updates">
        <div class="hero__text">
            <h1 class="hero__title">Open Source Package Updates</h1>
        </div>
    </header>
    <section class="pt-4">
        <div class="container">
            @forelse($updates as $update)
                <article class="mb-3">
                    <header class="section-heading">
                        <h2>{{ $update->title }}</h2>
                    </header>
                    <div>
                        {!! $update->intro !!}
                    </div>
                    <div>
                        <a class="btn btn-brand" href="{{ route('open-source.update', ['update' => $update]) }}">Read Update</a>
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
