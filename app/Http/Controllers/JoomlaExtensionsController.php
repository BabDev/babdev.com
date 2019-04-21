<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\JoomlaExtension;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class JoomlaExtensionsController extends Controller
{
    /**
     * Displays the Joomla! extensions list
     *
     * @return Response
     */
    public function index(): Response
    {
        /** @var Collection|JoomlaExtension[] $extensions */
        $extensions = JoomlaExtension::query()
            ->orderBy('name')
            ->get();

        return response()->view('extensions.index', ['extensions' => $extensions]);
    }
}
