@extends('layouts.app', [
    'title' => sprintf('Privacy | %s', config('app.name', 'BabDev')),
])

@section('content')
    <x-hero title="Site Privacy" />
    <article class="pt-4">
        <div class="container">
            <div class="section-heading">
                <h2>Summary</h2>
            </div>
            <p>This site is designed with privacy in mind and tends to take a privacy first approach.</p>
            <div class="section-heading">
                <h2>Collected Information</h2>
            </div>
            <p>Some potentially identifying information is collected as a result of visiting this website. This information, and the purpose of its collection, includes:</p>
            <ul>
                <li>IP Address - Your IP address is collected and stored in the web server's logs and security tools as a means of ensuring the security of this website and preventing abuse.</li>
            </ul>
            <div class="section-heading">
                <h2>External Services</h2>
            </div>
            <p>There are some integrations with third party services to improve the capabilities of this site.</p>
            <div class="section-heading">
                <h3>InnoCraft</h3>
            </div>
            <p>This site uses the below services provided by InnoCraft Ltd:</p>
            <ul>
                <li>Matomo Cloud - To collect analytics regarding website traffic</li>
            </ul>
            {{ Breadcrumbs::render('privacy') }}
        </div>
    </article>
@endsection
