@extends('layouts.app', [
    'title' => 'BabDev - Open Source Solutions for PHP Applications',
])

@section('main-classes', 'pb-3')

@section('content')
    <section class="hero hero--homepage">
        <div class="hero__text">
            <h1 class="hero__title">Creating Open Source Solutions Since 2010</h1>
        </div>
    </section>
    <section class="homepage-callouts">
        <div class="callout callout__title callout--who-i-am">
            <h3 class="callout__heading">Who I Am</h3>
        </div>
        <div class="callout callout__text callout--who-i-am-info">
            I am <a href="https://michaels.website" rel="nofollow noopener">Michael Babker</a>, a long tenured contributor to the Open Source software community and Lead Developer for <a href="https://hdwebpros.com" rel="nofollow noopener">Happy Dog Web Productions</a>.
        </div>
        <div class="callout callout__title callout--what-i-do">
            <h3 class="callout__heading">What I Do</h3>
        </div>
        <div class="callout callout__text callout--what-i-do-info">
            As an open source contributor and developer, I create solutions to help others fulfill their own requirements for PHP projects (primarily with the Symfony and Laravel frameworks). As the Lead Developer of Happy Dog Web Productions, I work closely with clients to create solutions tailored to their business needs.
        </div>
    </section>
@endsection
