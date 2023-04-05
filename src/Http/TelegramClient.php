<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Contracts\HttpClientInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\HasToken;

/**
 * Class TelegramClient.
 */
class TelegramClient
{
    use HasToken;

    /** @var string Telegram Bot API URL. */
    protected string $baseApiUrl = 'https://api.telegram.org';

    /** @var HttpClientInterface HTTP Client. */
    protected HttpClientInterface $httpClientHandler;

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected bool $isAsyncRequest = false;

    /** @var TelegramResponse|null Stores the last request made to Telegram Bot API. */
    protected ?TelegramResponse $lastResponse = null;

    /**
     * Instantiates a new TelegramClient object.
     *
     * @param HttpClientInterface|null $httpClientHandler
     */
    public function __construct(HttpClientInterface $httpClientHandler = null)
    {
        $this->httpClientHandler = $httpClientHandler ?? new GuzzleHttpClient();
    }

    /**
     * Returns the HTTP client handler.
     */
    public function getHttpClientHandler(): HttpClientInterface
    {
        return $this->httpClientHandler;
    }

    /**
     * Sets the HTTP client handler.
     *
     *
     * @return $this
     */
    public function setHttpClientHandler(HttpClientInterface $httpClientHandler): self
    {
        $this->httpClientHandler = $httpClientHandler;

        return $this;
    }

    /**
     * Get HTTP Client config.
     */
    public function getConfig(): array
    {
        return $this->getHttpClientHandler()->getConfig();
    }

    /**
     * Set HTTP Client config.
     *
     *
     * @return $this
     */
    public function setConfig(array $config): self
    {
        $this->getHttpClientHandler()->setConfig($config);

        return $this;
    }

    /**
     * Get the Base API URL.
     */
    public function getBaseApiUrl(): string
    {
        return $this->baseApiUrl;
    }

    /**
     * Set the Base API URL.
     *
     *
     * @return $this
     */
    public function setBaseApiUrl(string $baseApiUrl): self
    {
        $this->baseApiUrl = rtrim($baseApiUrl, '/');

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     */
    public function isAsyncRequest(): bool
    {
        return $this->isAsyncRequest;
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     *
     * @return $this
     */
    public function setAsyncRequest(bool $isAsyncRequest): self
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Returns the last response returned from API request.
     */
    public function getLastResponse(): ?TelegramResponse
    {
        return $this->lastResponse;
    }

    /**
     * Get File URL.
     *
     * @param string|null $path
     *
     * @throws TelegramSDKException
     */
    public function getFileUrl(string $path = null): string
    {
        return sprintf('%s/file/bot%s/%s', $this->getBaseApiUrl(), $this->getToken(), $path);
    }

    /**
     * Sends a GET request to Telegram Bot API and returns the result.
     *
     *
     * @throws TelegramSDKException
     */
    public function get(string $endpoint, array $query = []): TelegramResponse
    {
        return $this->sendRequest('GET', $endpoint, ['query' => $query]);
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     *
     *
     * @throws TelegramSDKException
     */
    public function post(string $endpoint, array $json = []): TelegramResponse
    {
        return $this->sendRequest('POST', $endpoint, ['json' => $json]);
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     *
     *
     * @throws TelegramSDKException
     */
    public function uploadFile(string $endpoint, array $multipart): TelegramResponse
    {
        return $this->sendRequest('POST', $endpoint, ['multipart' => $multipart]);
    }

    /**
     * Download file from Telegram server for given file path.
     *
     * @param string $filePath File path on Telegram server.
     * @param string $filename Download path to save file.
     *
     * @throws TelegramSDKException
     */
    public function download(string $filePath, string $filename): string
    {
        $fileDir = dirname($filename);

        // Ensure dir is created.
        if (! @mkdir($fileDir, 0755, true) && ! is_dir($fileDir)) {
            throw TelegramSDKException::fileDownloadFailed('Directory ' . $fileDir . ' can\'t be created');
        }

        $request = $this->resolveTelegramRequest('GET', '');

        $response = $this->getHttpClientHandler()->send(
            $url = $this->getFileUrl($filePath),
            $request->getMethod(),
            $request->getHeaders(),
            ['sink' => $filename],
            $request->isAsyncRequest(),
        );

        if ($response->getStatusCode() !== 200) {
            throw TelegramSDKException::fileDownloadFailed($response->getReasonPhrase(), $url);
        }

        return $filename;
    }

    /**
     * Instantiates a new TelegramRequest entity.
     *
     *
     * @throws TelegramSDKException
     */
    protected function resolveTelegramRequest(
        string $method,
        string $endpoint,
        array $params = []
    ): TelegramRequest {
        return new TelegramRequest(
            $this->getToken(),
            $method,
            $endpoint,
            $params,
            $this->isAsyncRequest()
        );
    }

    /**
     * Sends a request to Telegram Bot API and returns the result.
     *
     *
     * @throws TelegramSDKException
     *
     */
    protected function sendRequest(
        string $method,
        string $endpoint,
        array $params = []
    ): TelegramResponse {
        $request = $this->resolveTelegramRequest($method, $endpoint, $params);

        $rawResponse = $this->getHttpClientHandler()->send(
            $this->makeApiUrl($request),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getParams(),
            $request->isAsyncRequest(),
        );

        $returnResponse = $this->getResponse($request, $rawResponse);

        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }

        return $this->lastResponse = $returnResponse;
    }

    /**
     * Make API URL.
     *
     *
     * @throws TelegramSDKException
     */
    protected function makeApiUrl(TelegramRequest $request): string
    {
        return sprintf('%s/bot%s/%s', $this->getBaseApiUrl(), $request->getToken(), $request->getEndpoint());
    }

    /**
     * Creates response object.
     *
     *
     */
    protected function getResponse(TelegramRequest $request, ResponseInterface|PromiseInterface $response): TelegramResponse
    {
        return new TelegramResponse($request, $response);
    }
}
