@extends('layouts.app', [
    'title' => sprintf('Sponsor | %s', config('app.name', 'BabDev')),
])

@section('content')
    <x-hero title="Sponsor Open Source Development" />
    <article class="pt-4">
        <div class="container">
            <p>Development and maintenance of open source software requires a significant resource commitment from those who are doing so. My contributions to open source over the past 10 years averages at least 20 hours per week in issue triage, code review, maintaining code and documentation, preparing materials for presentations at a number of conferences, and maintaining support resources such as this website.</p>
            <p>The software distributed under BabDev is released as open source software that is available free of cost, but that gratuity does not pay the bills on its own. Sponsorships are greatly appreciated in order to help be able to continue produce free and open source software and the resources required to support that software.</p>
            <p>If you are interested in sponsoring my open source efforts, please visit <a href="https://github.com/sponsors/mbabker" target="_blank" rel="nofollow noopener">my GitHub sponsors profile</a> for more information.</p>

            <div class="text-center mb-4">
                <iframe src="https://github.com/sponsors/mbabker/card" title="Sponsor mbabker on GitHub" loading="lazy" height="150" width="600" style="border: 0;"></iframe>
            </div>

            {{ Breadcrumbs::render('sponsor') }}
        </div>
    </article>
@endsection
