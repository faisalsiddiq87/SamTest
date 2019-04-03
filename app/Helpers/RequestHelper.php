<?php

namespace App\Helpers;

class RequestHelper
{
    public static function run($request, $url, $type = 'GET', $data = [])
    {
        $response = [];

        try {
            $token = $request->header('Authorization');

            $tokenRequest = $request->create(env('APP_URL') . '/api/v1/' . $url, $type, $data);

            $tokenRequest->headers->set('Authorization', $token);

            $response = app()->handle($tokenRequest)->getContent();

            $response  = json_decode($response, true);
        } catch (\Exception $e) {
        }

        return $response;
    }
}