<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use League\OAuth2\Client\Provider\GenericProvider;

class AweberController extends Controller
{
    private $accessToken;
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $scope;

    public function __construct()
    {
        $this->accessToken = 'YOUR_AWEBER_ACCESS_TOKEN';
        $this->clientId = 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H';
        $this->clientSecret = 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv';
        $this->redirectUri = 'http://127.0.0.1:8000/api/aweber/token';
        $this->scope = 'account.read list.read';
    }

    function redirectToAweberAuthorization(Request $request)
    {
        // Replace with your AWeber credentials
        $clientId = 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H';
        $redirectUri = 'http://127.0.0.1:8000/api/aweber/token';

        $scope = 'account.read list.read'; // Specify the desired scope

        // Build the AWeber authorization URL
        $authorizationUrl = sprintf(
            'https://auth.aweber.com/oauth2/authorize?response_type=code&client_id=%s&scope=%s&redirect_uri=%s',
            $this->clientId,
            $this->scope,
            $this->redirectUri
        );
        // Redirect the user to the AWeber authorization URL
        return redirect()->away($authorizationUrl);
    }

    function getAweberToken(Request $request)
    {
        $this->clientId = 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H';
        $this->clientSecret = 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv';
        $response = Http::asForm()->post('https://auth.aweber.com/oauth2/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->successful()) {
            $token = $response->json()['access_token'];
            $this->getAweberAccountId($token);
            return response()->json(['token' => $token]);
        } else {
            $error = $response->json();

            return response()->json(['error' => $error], $response->status());
        }
    }

    public function getAweberAccountId($token)
    {
        // Build the AWeber API endpoint URL
        $url = 'https://api.aweber.com/1.0/accounts';

        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $accounts = $response->json();

            return $accounts;
            // if (count($accounts) > 0) {
            //     $accountId = $accounts;
            //     return response()->json(['account_id' => $accountId]);
            // }
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            // Handle the error response
            // ...
        }
    }

    public function getAweberSubscribers(Request $request)
    {
        // Replace with your AWeber credentials
        $accountId = 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H';
        $listId = 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv';

        // Build the AWeber API endpoint URL
        $url = "https://api.aweber.com/1.0/accounts/{$accountId}/lists/{$listId}/subscribers";

        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer GDZ3ylI5WNJ7OZFY7YyFgnbZCryB2Uyl',
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $subscribers = $response->json();

            // Process the list of subscribers as needed
            // ...

            return response()->json($subscribers);
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            // Handle the error response
            // ...
        }
    }
    private function getAccessToken($clientId, $clientSecret, $redirectUri, $authorizationCode, $codeVerifier)
    {
        // Build the AWeber token endpoint URL
        $url = 'https://auth.aweber.com/oauth2/token';

        // Prepare the request payload
        $payload = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $authorizationCode,
            'code_verifier' => $codeVerifier,
        ];

        // Make the API request to exchange the authorization code for an access token
        $response = Http::post($url, $payload);

        if ($response->successful()) {
            $responseData = $response->json();
            $accessToken = $responseData['access_token'];

            // Store or handle the access token as needed

            return $accessToken;
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            // Handle the error response
            // ...
        }
    }
}
