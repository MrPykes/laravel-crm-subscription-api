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
    private $token;

    public function __construct()
    {
        $this->clientId = 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H';
        $this->clientSecret = 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv';
        $this->redirectUri = 'http://127.0.0.1:8000/api/aweber/token';
        $this->scope = 'account.read list.read subscriber.read subscriber.write';
        $this->token = '65vVdAcWDLnaT9DMKWELz1VNjW9GwKIL';
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
        // $this->clientId = 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H';
        // $this->clientSecret = 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv';
        $response = Http::asForm()->post('https://auth.aweber.com/oauth2/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->successful()) {
            $token = $response->json()['access_token'];
            return response()->json(['token' => $token]);
        } else {
            $error = $response->json();

            return response()->json(['error' => $error], $response->status());
        }
    }

    public function getAweberAccountId()
    {
        // Build the AWeber API endpoint URL
        // $url = 'https://api.aweber.com/1.0/accounts';
        // $url = "https://api.aweber.com/1.0/accounts/1643136/lists/";
        // $url = "https://api.aweber.com/1.0/accounts/1643136/lists/5839405";
        // $url = "`https://api.aweber.com/1.0/accounts/1643136/lists/5839405/subscribers";

        $url = "https://api.aweber.com/1.0/accounts/5844925/lists/";


        // Make the API request

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $accounts = $response->json();
            // $accountId = $accounts['entries'][0]['id'];

            dd($accounts);
            // $subscribers = $this->getAweberSubscribers($accountId);

            return $accounts;
            // if (count($accounts) > 0) {
            //     $accountId = $accounts;
            //     return response()->json(['account_id' => $accountId]);
            // }
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            dd($error);
            // Handle the error response
            // ...
        }
    }

    public function getAweberSubscribers()
    {
        // Replace with your AWeber credentials;

        // Build the AWeber API endpoint URL
        // $url = "https://api.aweber.com/1.0/accounts/{$accountId}/lists/";
        // $url = "https://api.aweber.com/1.0/accounts/1643136/lists/5839405/subscribers";
        $url = "https://api.aweber.com/1.0/accounts/me/lists/5844925/subscribers";


        // Make the API request
        $response = Http::withHeaders([
            // 'User-Agent' => 'AWeber-PHP-code-sample/1.0',
            'Authorization' => 'Bearer ' . $this->token,
            // 'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $subscribers = $response->json();
            // Process the list of subscribers as needed
            // ...
            dd(response()->json($subscribers));
            return response()->json($subscribers);
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            dd($error);
            // Handle the error response
            // ...
        }
    }

    function findAweberSubscriber($email)
    {
        $url = "https://api.aweber.com/1.0/accounts/1643136/lists/5844925/subscribers";
        // $url = "https://api.aweber.com/1.0/accounts/{$accountId}/lists/{$listId}/subscribers";
        $params = [
            'ws.op' => 'find',
            'email' => $email,
        ];
        $findUrl = $url . '?' . http_build_query($params);
        // $response = $client->get($findUrl, ['headers' => $headers]);
        // $body = json_decode($response->getBody(), true);
        $response = Http::withHeaders([
            'User-Agent' => 'AWeber-PHP-code-sample/1.0',
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->get($findUrl);

        if ($response->successful()) {
            $content = $response->json();
            $entries = $content['entries'][0];
            return $entries;
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            // Handle the error response
            // ...
        }
    }
    function deleteAweberSubscriber()
    {
        $entries = $this->findAweberSubscriber('edcali704.webdev@gmail.com');

        $url = "https://api.aweber.com/1.0/accounts/1643136/lists/5844925/subscribers/80026217";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->delete($url);

        dd($response->json());
        if ($response->successful()) {
            echo 'Subscriber deleted successfully.';
        } else {
            echo 'Request failed. Status code: ' . $response->status();
        }
    }
}
