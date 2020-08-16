<?php

namespace BabDev\GitHub\Actions;

use BabDev\Contracts\GitHub\Actions\Action;
use Github\Client;
use Illuminate\Http\Request;

class ClosePagerfantaReadOnlyRepoPullRequest implements Action
{
    public function __invoke(array $repoConfig, Request $request, Client $github): void
    {
        if ($request->input('action') !== 'opened') {
            return;
        }

        $github->api('issue')->comments()->create(
            $request->input('repository.owner.login'),
            $request->input('repository.name'),
            $request->input('number'),
            [
                'body' => <<<MD
Thank you for your pull request to Pagerfanta, unfortunately your pull request cannot be accepted on this repository.

This repository is a read-only copy of a portion of the main Pagerfanta repository, which is the canonical repository for all Pagerfanta related code.

In order for your pull request to be accepted, you will need to submit it to https://github.com/BabDev/Pagerfanta for review.
MD
                ,
            ]
        );

        $github->api('pull_request')->update(
            $request->input('repository.owner.login'),
            $request->input('repository.name'),
            $request->input('number'),
            [
                'state' => 'closed',
            ]
        );
    }
}
