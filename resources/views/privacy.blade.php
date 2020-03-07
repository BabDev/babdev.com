@extends('layouts.app')

@section('title', sprintf('Privacy | %s', config('app.name', 'Laravel')))

@section('content')
    <section class="hero hero--privacy">
        <div class="hero__text">
            <h1 class="hero__title">Site Privacy</h1>
        </div>
    </section>
    <section class="privacy pt-4">
        <div class="container">
            <div class="alert alert-info">
                <div class="alert-heading">Work In Progress</div>
                <div>This document is a work in progress, for now it is a very loose summary of pertinent bits.</div>
            </div>
            <div class="section-heading">
                <h2>Summary</h2>
            </div>
            <p>This site is designed with privacy in mind and tends to take a privacy first approach.</p>
            <div class="section-heading">
                <h2>External Services</h2>
            </div>
            <p>There are some integrations with third party services to improve the capabilities of this site.</p>
            <div class="section-heading">
                <h3>Google</h3>
            </div>
            <p>This site uses the below services provided by Google LLC:</p>
            <ul>
                <li>Google Fonts - To provide extended typography consistent with the BabDev branding</li>
            </ul>
            {{ Breadcrumbs::render('privacy') }}
        </div>
    </section>
@endsection
