<?php

namespace IvaoFrance\ApiClient;

class ApiClient
{
    protected $config, $authentication;

    public function __construct($apiId, $apiSecret, $apiUrl)
    {
        $this->config['api_access_id'] = $apiId;
        $this->config['api_secret'] = $apiSecret;
        $this->config['api_url'] = $apiUrl;
        $this->sanitizeUrl();
        $this->authentication = null;
    }

    protected function sanitizeUrl()
    {
        $this->config['api_url'] = rtrim($this->config['api_url'], '/');
    }

    public function request($entryPoint, $method = 'GET', $data = null)
    {
        $entryPoint = $this->sanitizeEntryPoint($entryPoint);
        if (!$this->authenticated()) {
            $this->authenticate();
        }

        return $this->getResponse($entryPoint, $method, $data, true);
    }

    protected function sanitizeEntryPoint($entryPoint)
    {
        $entryPoint = rtrim($entryPoint, '/');
        return '/' . ltrim($entryPoint, '/');
    }

    protected function authenticated()
    {
        return !is_null($this->authentication);
    }

    protected function authenticate()
    {
        $token = $this->getAuthenticationToken();
        $signature = $this->getSignature($token);
        $this->authentication = compact('token', 'signature');
    }

    protected function getAuthenticationToken()
    {
        $response = $this->getResponse('/', 'GET', ['id' => $this->config['api_access_id']], false);
        if (!isset($response->token)) {
            throw new ApiException('Unable to authenticate at ' . $this->config['api_url']);
        }
        return $response->token;
    }

    protected function getResponse($entryPoint, $method, $data, $authenticate)
    {
        $entryPoint = $this->sanitizeEntryPoint($entryPoint);
        $url = $this->config['api_url'] . $entryPoint;
        $method = strtoupper($method);

        if ($method == 'GET' && !is_null($data)) {
            $url .= '?' . http_build_query($data);
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($method != 'GET') {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            if (!is_null($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        }

        if ($authenticate) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Accept: text/json',
                'Token: ' . $this->authentication['token'],
                'Signature: ' . $this->authentication['signature'],
            ]);
        }

        $response = curl_exec($curl);

        if ($response === false) {
            $message = curl_error($curl);
            curl_close($curl);
            throw new ApiException($message);
        }
        curl_close($curl);
        $json = json_decode($response);
        if (!isset($json->status)) {
            throw new ApiException('unexpected content');
        }

        if ($json->status == 'error') {
            throw new ApiException($json->contents->message);
        }
        return $json->contents;
    }

    protected function getSignature($string)
    {
        return hash_hmac('sha256', $string, $this->config['api_secret']);
    }

}