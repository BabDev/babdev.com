@php /** @var \BabDev\Pagination\RoutableLengthAwarePaginator|\BabDev\Models\PackageUpdate[] $updates */ @endphp

@extends('layouts.app', [
    'title' => sprintf('Open Source Updates | %s', config('app.name', 'BabDev')),
])

@section('content')
    <x-hero title="Open Source Package Updates" />
    <section class="pt-4">
        <div class="container package-update">
            @forelse($updates as $update)
                <article class="mb-3">
                    <header class="section-heading">
                        <h2>{{ $update->title }}</h2>
                    </header>
                    <div class="item-published">
                        <span class="item-published__icon">{{ svg('far-calendar') }}</span>
                        <span class="item-published__date">{{ $update->published_at->format('F j, Y') }}</span>
                    </div>
                    <div class="package-update__intro">
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
