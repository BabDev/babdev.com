<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest;
use Github\Api\Issue;
use Github\Api\Issue\Comments;
use Github\Api\PullRequest;
use Github\Client;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class ClosePagerfantaReadOnlyRepoPullRequestTest extends TestCase
{
    #[Test]
    public function the_action_only_processes_opened_pull_requests(): void
    {
        $request = Request::createFromBase(
            SymfonyRequest::create('/webhooks/github/app', 'POST', ['action' => 'closed']),
        );

        /** @var MockObject&Client $github */
        $github = $this->createMock(Client::class);
        $github->expects($this->never())
            ->method('api');

        $action = new ClosePagerfantaReadOnlyRepoPullRequest();
        $action(['app_id' => '123', 'key' => 'key', 'secret' => 'secret', 'events' => []], $request, $github);
    }

    #[Test]
    public function the_action_comments_on_an_opened_pull_request_and_closes_it(): void
    {
        $request = Request::createFromBase(
            SymfonyRequest::create(
                '/webhooks/github/app',
                'POST',
                [
                    'action' => 'opened',
                    'number' => '1',
                    'repository' => [
                        'owner' => [
                            'login' => 'Pagerfanta',
                        ],
                        'name' => 'core',
                    ],
                ],
            ),
        );

        /** @var MockObject&Comments $comments */
        $comments = $this->createMock(Comments::class);
        $comments->expects($this->once())
            ->method('create')
            ->with(
                'Pagerfanta',
                'core',
                '1',
                $this->isType('array'),
            );

        /** @var MockObject&Issue $issue */
        $issue = $this->createMock(Issue::class);
        $issue->expects($this->once())
            ->method('comments')
            ->willReturnOnConsecutiveCalls($comments);

        /** @var MockObject&PullRequest $pullRequest */
        $pullRequest = $this->createMock(PullRequest::class);
        $pullRequest->expects($this->once())
            ->method('update')
            ->with(
                'Pagerfanta',
                'core',
                '1',
                [
                    'state' => 'closed',
                ],
            );

        /** @var MockObject&Client $github */
        $github = $this->createMock(Client::class);
        $github->expects($this->exactly(2))
            ->method('__call')
            ->willReturnMap([
                ['issue', [], $issue],
                ['pullRequest', [], $pullRequest],
            ]);

        $action = new ClosePagerfantaReadOnlyRepoPullRequest();
        $action(['app_id' => '123', 'key' => 'key', 'secret' => 'secret', 'events' => []], $request, $github);
    }
}
