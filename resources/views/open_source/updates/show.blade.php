@php /** @var \BabDev\Models\PackageUpdate $update */ @endphp

@extends('layouts.app')

@section('title', sprintf('%s | Open Source Updates | %s', $update->title, config('app.name', 'Laravel')))

@section('content')
    <header class="package-title{{ $update->package->logo ? ' package-title--has-logo' : '' }} pt-4">
        @if($update->package->logo)
            <div class="package-title__logo">
                <img src="{{ Storage::disk('logos')->url($update->package->logo) }}" alt="{{ $update->package->display_name }} Logo">
            </div>
        @endif
        <div class="package-title__name">
            <h1 class="package-title__primary">{{ $update->package->display_name }}</h1>
            <h2 class="package-title__secondary">Package Update</h2>
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
