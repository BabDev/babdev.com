@php /** @var \Illuminate\Database\Eloquent\Collection|\BabDev\Models\JoomlaExtension[] $extensions */ @endphp

@extends('layouts.app')

@section('title')Joomla! Extensions | {{ config('app.name', 'Laravel') }}@endsection

@section('content')
    <section class="hero hero--extensions">
        <div class="hero__text">
            <h1 class="hero__title">Joomla! Extensions</h1>
        </div>
    </section>
    <section class="extensions pt-4">
        <div class="container">
            @forelse($extensions as $extension)
                <div class="extension">
                    <div class="extension__name">
                        <h2>{{ $extension->name }}</h2>
                    </div>
                    <div class="extension__logo">
                        <img src="{{ Storage::disk('logos')->url($extension->logo) }}" alt="{{ $extension->name }} Logo">
                    </div>
                    <div class="extension__description">
                        {!! $extension->description !!}
                        <div class="extension__links">
                            <a class="btn btn-brand" href="#">View Documentation</a>
                            <a class="btn btn-brand" href="#">View Downloads</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <div class="alert-heading">No Extensions</div>
                    <div>Sorry, there are no extensions available at this time.</div>
                </div>
            @endforelse
            {{ Breadcrumbs::render('joomla-extensions.index') }}
        </div>
    </section>
@endsection
