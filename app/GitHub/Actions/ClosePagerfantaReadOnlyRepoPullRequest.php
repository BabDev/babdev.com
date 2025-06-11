<?php

namespace App\GitHub\Actions;

use App\Contracts\GitHub\Actions\Action;
use Github\Client;
use Illuminate\Http\Request;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
final class ClosePagerfantaReadOnlyRepoPullRequest implements Action
{
    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function __invoke(#[\SensitiveParameter] array $repoConfig, Request $request, Client $github): void
    {
        if ($request->input('action') !== 'opened') {
            return;
        }

        $github->issue()->comments()->create(
            $request->string('repository.owner.login')->toString(),
            $request->string('repository.name')->toString(),
            $request->integer('number'),
            [
                'body' => <<<MD
                    Thank you for your pull request to Pagerfanta, unfortunately your pull request cannot be accepted on this repository.

                    This repository is a read-only copy of a portion of the main Pagerfanta repository, which is the canonical repository for all Pagerfanta related code.

                    In order for your pull request to be accepted, you will need to submit it to https://github.com/BabDev/Pagerfanta for review.
                    MD,
            ],
        );

        $github->pullRequest()->update(
            $request->string('repository.owner.login')->toString(),
            $request->string('repository.name')->toString(),
            $request->integer('number'),
            [
                'state' => 'closed',
            ],
        );
    }
}
