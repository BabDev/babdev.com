<?php

namespace BabDev\NovaMediaLibrary\Http\Resources;

use BabDev\NovaMediaLibrary\Concerns\HandlesUrlConversions;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    use HandlesUrlConversions;

    public function toArray($request)
    {
        return \array_merge($this->resource->toArray(), ['__media_urls__' => $this->getConversionUrls($this->resource)]);
    }
}
