@php /** @var \BabDev\Models\PackageUpdate $update */ @endphp

@extends('layouts.app')

@section('title', sprintf('%s | Open Source Updates | %s', $update->title, config('app.name', 'Laravel')))

@section('content')
    <header class="hero">
        <div class="hero__text">
            <h1 class="hero__title">{{ $update->package->display_name }}</h1>
            <h2 class="hero__subtitle">Package Update</h2>
        </div>
    </header>
    <article class="pt-4">
        <div class="container">
            <header class="section-heading">
                <h2>{{ $update->title }}</h2>
            </header>
            <div>
                {!! $update->content !!}
            </div>
            {{ Breadcrumbs::render('open-source.update', $update) }}
        </div>
    </article>
@endsection
