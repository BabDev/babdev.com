<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest;
use Github\Api\Issue;
use Github\Api\Issue\Comments;
use Github\Api\PullRequest;
use Github\Client;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClosePagerfantaReadOnlyRepoPullRequestTest extends TestCase
{
    /** @test */
    public function the_action_only_processes_opened_pull_requests()
    {
        /** @var MockObject&Request $request */
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('input')
            ->with('action')
            ->willReturn('closed');

        /** @var MockObject&Client $github */
        $github = $this->createMock(Client::class);

        $action = new ClosePagerfantaReadOnlyRepoPullRequest();
        $action([], $request, $github);
    }

    /** @test */
    public function the_action_comments_on_an_opened_pull_request_and_closes_it()
    {
        /** @var MockObject&Request $request */
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(7))
            ->method('input')
            ->withConsecutive(
                ['action'],
                ['repository.owner.login'],
                ['repository.name'],
                ['number'],
                ['repository.owner.login'],
                ['repository.name'],
                ['number']
            )
            ->willReturnOnConsecutiveCalls(
                'opened',
                'pagerfanta-packages',
                'core',
                '1',
                'pagerfanta-packages',
                'core',
                '1'
            );

        /** @var MockObject&Comments $comments */
        $comments = $this->createMock(Comments::class);
        $comments->expects($this->once())
            ->method('create')
            ->with(
                'pagerfanta-packages',
                'core',
                '1',
                $this->isType('array')
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
                'pagerfanta-packages',
                'core',
                '1',
                [
                    'state' => 'closed',
                ]
            );

        /** @var MockObject&Client $github */
        $github = $this->createMock(Client::class);
        $github->expects($this->exactly(2))
            ->method('api')
            ->withConsecutive(
                ['issue'],
                ['pull_request'],
            )
            ->willReturnOnConsecutiveCalls(
                $issue,
                $pullRequest
            );

        $action = new ClosePagerfantaReadOnlyRepoPullRequest();
        $action([], $request, $github);
    }
}
