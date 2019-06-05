<?php

namespace App\GraphQL\Mutations;

use Illuminate\Http\Request;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class BaseAuthResolver
{
    /**
     * @param array $args
     * @param string $grantType
     * @return mixed
     */
    public function buildCredentials(array $args = [], $grantType = "password")
    {

        $credentials = collect($args)->get('data');
        $credentials['username'] = $credentials['country_code'] . $credentials['phone_number'];

        unset($credentials['country_code'], $credentials['phone_number']);

        $credentials['client_id'] = config('app.passport_client_id');
        $credentials['client_secret'] = config('app.passport_client_secret');
        $credentials['grant_type'] = $grantType;
        return $credentials;
    }

    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials,[], [], [
            'HTTP_Accept' => 'application/json'
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);

        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException($decodedResponse['message']);
        }
        return $decodedResponse;
    }
}
