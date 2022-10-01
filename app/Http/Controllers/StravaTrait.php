<?php

namespace App\Http\Controllers;

trait StravaTrait
{
    protected function exchangeTokenRequest($code)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => env('STRAVA_OAUTH_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'client_id' => env('STRAVA_CLIENT_ID'),
                    'client_secret' => env('STRAVA_CLIENT_SECRET'),
                    'code' => $code,
                    'grant_type' => 'authorization_code'
                ]
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $data = json_decode($response);
            curl_close($curl);

            return [
                'httpCode' => $httpCode,
                'data' => $data
            ];
            // invalid response
            // {"message":"Authorization Error","errors":[{"resource":"Application","field":"","code":"invalid"}]}
            // success response
            // {"token_type":"Bearer","expires_at":1664233221,"expires_in":21600,"refresh_token":"8d016910f17c460f9f3276a333d45f4c568cc5e7","access_token":"c2fea0967afa2feec760a73e443a9ec3be59658a","athlete":{"id":18067797,"username":"wsakti","resource_state":2,"firstname":"Wira","lastname":"Sakti","bio":"","city":"Bandung","state":"West Java","country":"Indonesia","sex":"M","premium":false,"summit":false,"created_at":"2016-10-16T11:15:04Z","updated_at":"2022-09-23T04:16:58Z","badge_type_id":0,"weight":58.0,"profile_medium":"https://dgalywyr863hv.cloudfront.net/pictures/athletes/18067797/6365879/6/medium.jpg","profile":"https://dgalywyr863hv.cloudfront.net/pictures/athletes/18067797/6365879/6/large.jpg","friend":null,"follower":null}}

        } catch (\Exception $e) {
            return [
                'httpCode' => null,
                'data' => ['message' => 'Failed to get token.']
            ];
        }
    }

    protected function refreshTokenRequest($refreshToken)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => env('STRAVA_OAUTH_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'client_id' => env('STRAVA_CLIENT_ID'),
                    'client_secret' => env('STRAVA_CLIENT_SECRET'),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken
                ]
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $data = json_decode($response);
            curl_close($curl);

            return [
                'httpCode' => $httpCode,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'httpCode' => null,
                'data' => ['message' => 'Failed to call refresh token.']
            ];
        }
    }

    protected function getNewActivity($token, $id)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('STRAVA_API_URL') . '/activities/' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            return [
                'status' => true,
                'httpCode' => $httpCode,
                'data' => $response
            ];
            curl_close($curl);
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        }
    }
}
