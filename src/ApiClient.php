<?php

/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Yemenifree\PickServices;

use Zttp\Zttp;
use Zttp\ZttpResponse;

class ApiClient
{
    /** @var string */
    protected $apiEndPoint = 'https://api.pick.sa';
    /** @var string */
    protected $apiSandboxEndPoint = 'https://sandbox.pick.sa';
    /** @var array */
    protected $headers = [];
    /** @var bool */
    protected $sandbox = false;

    /**
     * Set token for auth services.
     *
     * @param $token
     *
     * @return ApiClient
     */
    public function setToken($token): self
    {
        $this->headers['X-Api-Key'] = $token;

        return $this;
    }

    /**
     * Process post request.
     *
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function post(string $endPoint, array $params = []): ZttpResponse
    {
        return $this->request('post', $endPoint, $params);
    }

    /**
     * process http request.
     *
     * @param string $method
     * @param string $endPoint
     * @param array  $params
     * @param bool   $asJson
     *
     * @return ZttpResponse
     */
    protected function request(string $method, string $endPoint, array $params = [], $asJson = true): ZttpResponse
    {
        $request = Zttp::withHeaders($this->getHeaders())
            ->withoutRedirecting();

        // if json except.
        if ($asJson === true) {
            $request->asJson();
        }

        return $request->{$method}($this->buildUrl($endPoint), $params);
    }

    /**
     * Get Headers request.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set headers of http  request.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Build full api url.
     *
     * @param $endPoint
     *
     * @return string
     */
    protected function buildUrl($endPoint): string
    {
        return $this->getEndPoint() . '/' . $endPoint;
    }

    /**
     * Get endpoint url.
     *
     * @return string
     */
    protected function getEndPoint(): string
    {
        return $this->sandbox ? $this->apiSandboxEndPoint : $this->apiEndPoint;
    }

    /**
     * Process get request.
     *
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function get(string $endPoint, array $params = []): ZttpResponse
    {
        return $this->request('get', $endPoint, $params, false);
    }

    /**
     * Process delete request.
     *
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function delete(string $endPoint, array $params = []): ZttpResponse
    {
        return $this->request('delete', $endPoint, $params);
    }

    /**
     * Process put request.
     *
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function put(string $endPoint, array $params): ZttpResponse
    {
        return $this->request('put', $endPoint, $params);
    }

    /**
     * Process patch request.
     *
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function patch(string $endPoint, array $params): ZttpResponse
    {
        return $this->request('patch', $endPoint, $params);
    }

    /**
     * Enable sandbox.
     *
     * @param bool $sandbox
     *
     * @return ApiClient
     */
    public function setSandbox(bool $sandbox): ApiClient
    {
        $this->sandbox = $sandbox;

        return $this;
    }
}
