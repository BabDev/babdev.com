@php /** @var \BabDev\Models\Package $package */ @endphp
@php /** @var \BabDev\Models\PackageRelease $release */ @endphp
@php /** @var \Illuminate\Support\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media */ @endphp

@extends('layouts.app')

@section('title', sprintf('%s %s Release | %s', $package->display_name, $release->version, config('app.name', 'Laravel')))

@section('content')
    <section class="package-title{{ $package->logo ? ' package-title--has-logo' : '' }} pt-4">
        @if($package->logo)
            <div class="package-title__logo">
                <img src="{{ Storage::disk('logos')->url($package->logo) }}" alt="{{ $package->display_name }} Logo">
            </div>
        @endif
        <div class="package-title__name">
            <h1 class="package-title__primary">{{ $package->display_name }}</h1>
            <h2 class="package-title__secondary">{{ $release->version }} Release</h2>
        </div>
    </section>
    <section class="package-releases container pt-2">
        @unless($package->supported)
            <div class="package-releases__unsupported-package alert alert-warning">
                <div class="alert-heading">Unsupported Extension</div>
                <div>The {{ $package->display_name }} extension is no longer supported, the releases remain available for download for historical reference.</div>
            </div>
        @endunless
        <div class="package-release">
            <div class="package-release__summary">
                {!! $release->summary !!}
            </div>
            <div class="package-release__info">
                <dl>
                    <dt>Maturity</dt>
                    <dd>{{ trans('stability.' . $release->maturity) }}</dd>
                    <dt>Released On</dt>
                    <dd>{{ $release->released_at->format('F j, Y') }}</dd>
                </dl>
            </div>
            <div class="package-release__downloads release-downloads{{ $media->isEmpty() ? ' release-downloads--no-downloads' : '' }}">
                @unless($media->isEmpty())
                    <div class="release-downloads__header">
                        <h3>Downloads</h3>
                    </div>
                    @foreach($media as $download)
                        <div class="release-download">
                            <div class="release-download__title">
                                <h4>{{ $download->getCustomProperty('display_title', $download->file_name) }}</h4>
                            </div>
                            @if($download->hasCustomProperty('description'))
                                <div class="release-download__description">
                                    {!! $download->getCustomProperty('description') !!}
                                </div>
                            @endif
                            <div class="release-download__info">
                                <dl>
                                    @if($download->hasCustomProperty('downloads'))
                                        <dt>Downloads</dt>
                                        <dd>{{ number_format((int) $download->getCustomProperty('downloads')) }}</dd>
                                    @endif
                                    <dt>File Size</dt>
                                    <dd>{{ $download->getHumanReadableSizeAttribute() }}</dd>
                                    @if($download->hasCustomProperty('md5_hash'))
                                        <dt>MD5 Signature</dt>
                                        <dd>{{ $download->getCustomProperty('md5_hash') }}</dd>
                                    @endif
                                    @if($download->hasCustomProperty('sha1_hash'))
                                        <dt>SHA1 Signature</dt>
                                        <dd>{{ $download->getCustomProperty('sha1_hash') }}</dd>
                                    @endif
                                </dl>
                            </div>
                            <div class="release-download__links">
                                <a class="btn btn-brand" href="{{ route('download-release-file', ['media' => $download]) }}">Download</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="release-downloads__no-downloads alert alert-info">
                        <div class="alert-heading">No Downloads</div>
                        <div>Sorry, there are no downloads available for this release.</div>
                    </div>
                @endunless
            </div>
        </div>
        {{ Breadcrumbs::render('open-source.package.release', $package, $release) }}
    </section>
@endsection
