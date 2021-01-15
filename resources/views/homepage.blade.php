@extends('layouts.app', [
    'title' => 'BabDev - Open Source Solutions for PHP Applications',
])

@section('main-classes', 'pb-3')

@section('content')
    <x-hero title="Creating Open Source Solutions Since 2010" class="hero--homepage" />
    <section class="homepage-callouts">
        <div class="callout callout__title callout--who-i-am">
            <h2 class="callout__heading">Who I Am</h2>
        </div>
        <div class="callout callout__text callout--who-i-am-info">
            I am <a href="https://michaels.website" rel="nofollow noopener">Michael Babker</a>, a long tenured contributor to the Open Source software community and Lead Data Architect for <a href="https://happydog.digital" rel="nofollow noopener">Happy Dog</a>.
        </div>
        <div class="callout callout__title callout--what-i-do">
            <h2 class="callout__heading">What I Do</h2>
        </div>
        <div class="callout callout__text callout--what-i-do-info">
            As an open source contributor and developer, I create solutions to help others fulfill their own requirements for PHP projects (primarily with the Symfony and Laravel frameworks). As the Lead Data Architect of Happy Dog, I work closely with clients to create solutions tailored to their business needs.
        </div>
    </section>
@endsection
