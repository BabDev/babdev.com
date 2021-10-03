<?php

namespace BabDev\Matomo;

use Carbon\Carbon;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\RequestException;

class ApiConnector
{
    private Factory $httpFactory;
    private string $matomoPageId;
    private string $matomoToken;
    private string $matomoUrl;

    public function __construct(Factory $httpFactory, string $matomoPageId, string $matomoToken, string $matomoUrl)
    {
        $this->httpFactory = $httpFactory;
        $this->matomoPageId = $matomoPageId;
        $this->matomoToken = $matomoToken;
        $this->matomoUrl = $matomoUrl;
    }

    /**
     * @throws RequestException
     */
    public function actions(string $method, int $range): array
    {
        return $this->request(
            [
                'module' => 'API',
                'method' => sprintf('Actions.%s', $method),
                'idSite' => $this->matomoPageId,
                'period' => 'range',
                'date' => sprintf('%s,%s', Carbon::now()->subDays($range)->toDateString(), Carbon::now()->toDateString()),
                'filter_limit' => 10,
                'format' => 'json',
            ],
        );
    }

    /**
     * @throws RequestException
     */
    public function visitsSummary(string $method, int $date = 7, ?string $segment = null): array
    {
        $query = [
            'module' => 'API',
            'method' => sprintf('VisitsSummary.%s', $method),
            'idSite' => $this->matomoPageId,
            'period' => 'day',
            'date' => sprintf('last%d', $date),
            'format' => 'json',
        ];

        if (!empty($segment)) {
            $query['segment'] = $segment;
        }

        return $this->request($query);
    }

    /**
     * @throws RequestException
     */
    private function request(array $query): array
    {
        $response = $this->httpFactory->get(
            $this->matomoUrl,
            array_merge(
                $query,
                [
                    'token_auth' => $this->matomoToken,
                ],
            ),
        );
        $response->throw();

        return $response->json();
    }
}
