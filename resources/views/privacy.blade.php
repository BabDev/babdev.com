@extends('layouts.app', [
    'title' => sprintf('Privacy | %s', config('app.name', 'BabDev')),
])

@section('content')
    <x-hero title="Site Privacy" />

    <article class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-6xl">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-8">
                        <div class="privacy-content">
                            <h2>Summary</h2>
                            <p>This site is designed with privacy in mind and tends to take a privacy first approach.</p>

                            <h2>Collected Information</h2>
                            <p>Some potentially identifying information is collected as a result of visiting this website. This information, and the purpose of its collection, includes:</p>
                            <ul>
                                <li>IP Address - Your IP address is collected and stored in the web server's logs and security tools as a means of ensuring the security of this website and preventing abuse.</li>
                            </ul>

                            <h2>External Services</h2>
                            <p>There are some integrations with third party services to improve the capabilities of this site.</p>

                            <h3>InnoCraft</h3>
                            <p>This site uses the below services provided by InnoCraft Ltd:</p>
                            <ul>
                                <li>Matomo Cloud - To collect analytics regarding website traffic</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    {{ Breadcrumbs::render('privacy') }}
                </div>
            </div>
        </div>
    </article>
@endsection
