<?php
namespace App\Infrastructure\Ssr\Engine;

use Spatie\Ssr\Engine;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NodeServerEngine implements Engine
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * NodeServer constructor.
     *
     * @param string $endpoint
     * @param HttpClientInterface $httpClient
     */
    public function __construct(string $endpoint, HttpClientInterface $httpClient)
    {
        $this->endpoint = $endpoint;
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function run(string $script): string
    {
        return $this->contactEndpoint($script);
    }

    /**
     * @inheritDoc
     */
    public function getDispatchHandler(): string
    {
        return 'console.log';
    }

    /**
     * @param $body
     *
     * @return string
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    private function contactEndpoint($body)
    {
        $response = $this->httpClient->request('POST', $this->endpoint, [
            'body' => $body
        ]);

        return $response->getContent();
    }


}