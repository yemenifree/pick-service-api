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
    protected $apiEndPoint = 'https://api.pick.sa';
    protected $headers = [];

    public function __construct()
    {
    }

    /**
     * set token for auth services.
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
    public function post(string $endPoint, array $params): ZttpResponse
    {
        return $this->request('post', $endPoint, $params);
    }

    /**
     * process http request.
     *
     * @param string $method
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    protected function request(string $method, string $endPoint, array $params = []): ZttpResponse
    {
        return Zttp::withHeaders($this->getHeaders())->{$method}($this->buildUrl($endPoint), $params);
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
        return $this->apiEndPoint . '/' . $endPoint;
    }

    /**
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function get(string $endPoint, array $params): ZttpResponse
    {
        return $this->request('get', $endPoint, $params);
    }

    /**
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function delete(string $endPoint, array $params): ZttpResponse
    {
        return $this->request('delete', $endPoint, $params);
    }

    /**
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
     * @param string $endPoint
     * @param array  $params
     *
     * @return ZttpResponse
     */
    public function patch(string $endPoint, array $params): ZttpResponse
    {
        return $this->request('patch', $endPoint, $params);
    }
}