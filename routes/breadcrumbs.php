<?php

use BabDev\Models\JoomlaExtension;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;

/** @var BreadcrumbsManager $breadcrumbs */

$breadcrumbs->for(
    'homepage',
    function (BreadcrumbsGenerator $trail) {
        $trail->push('Home', route('homepage'));
    }
);

$breadcrumbs->for(
    'privacy',
    function (BreadcrumbsGenerator $trail) {
        $trail->parent('homepage');
        $trail->push('Privacy', route('privacy'));
    }
);

$breadcrumbs->for(
    'joomla-extensions.index',
    function (BreadcrumbsGenerator $trail) {
        $trail->parent('homepage');
        $trail->push('Open Source');
        $trail->push('Joomla! Extensions', route('joomla-extensions.index'));
    }
);

$breadcrumbs->for(
    'joomla-extensions.releases.index',
    function (BreadcrumbsGenerator $trail, JoomlaExtension $extension) {
        $trail->parent('joomla-extensions.index');
        $trail->push('Releases');
        $trail->push($extension->name, route('joomla-extensions.releases.index', ['joomla_extension' => $extension]));
    }
);
