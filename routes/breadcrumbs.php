<?php

Breadcrumbs::for(
    'homepage',
    function ($trail) {
        $trail->push('Home', route('homepage'));
    }
);

Breadcrumbs::for(
    'privacy',
    function ($trail) {
        $trail->parent('homepage');
        $trail->push('Privacy', route('privacy'));
    }
);
