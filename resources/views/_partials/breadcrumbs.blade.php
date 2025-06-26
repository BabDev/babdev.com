@php /** @var \Illuminate\Support\Collection $breadcrumbs */ @endphp
@unless($breadcrumbs->isEmpty())
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-4">
            @foreach($breadcrumbs as $breadcrumb)
                @if($breadcrumb->title === 'Home')
                    <li>
                        <div>
                            <a href="{{ $breadcrumb->url }}" class="text-gray-400 hover:text-gray-500">
                                <x-fas-home class="h-5 w-5 flex-shrink-0 fill-current" /><span class="sr-only">{{ $breadcrumb->title }}</span>
                            </a>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="flex items-center">
                            <x-fas-slash class="h-5 w-5 flex-shrink-0 text-gray-300 fill-current rotate-90" />
                            @if($breadcrumb->url && !$loop->last)
                                <a href="{{ $breadcrumb->url }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $breadcrumb->title }}</a>
                            @elseif($loop->last)
                                <span class="ml-4 text-sm font-medium text-gray-900">{{ $breadcrumb->title }}</span>
                            @else
                                <span class="ml-4 text-sm font-medium text-gray-500">{{ $breadcrumb->title }}</span>
                            @endif
                        </div>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
