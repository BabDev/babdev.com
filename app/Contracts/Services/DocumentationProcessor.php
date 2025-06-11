<?php

namespace App\Contracts\Services;

use App\Contracts\Services\Exceptions\PageNotFoundException;
use App\Contracts\Services\Exceptions\UnsupportedEncodingException;
use App\Models\Package;

interface DocumentationProcessor
{
    public function generateDocsFileCacheKey(Package $package, string $version, string $pageSlug): string;

    public function extractTitle(string $markdown): string;

    /**
     * @throws PageNotFoundException        if the requested page does not exist
     * @throws UnsupportedEncodingException if the file encoding type is not supported
     */
    public function fetchPageContents(Package $package, string $version, string $pageSlug): string;
}
