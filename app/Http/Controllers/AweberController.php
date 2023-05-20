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
        $this->clientId = config('aweber.clientId');
        $this->clientSecret = config('aweber.clientSecret');
        $this->redirectUri = 'http://127.0.0.1:8000/api/aweber/token';
        $this->scope = 'account.read list.read subscriber.read subscriber.write';
        $this->token = config('aweber.access_token');
    }

    function login(Request $request)
    {
        $provider = new GenericProvider([
            'clientId' => 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H',
            'clientSecret' => 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv',
            'redirectUri' => 'http://127.0.0.1:8000/aweber/callback',
            'urlAuthorize' => 'https://auth.aweber.com/oauth2/authorize',
            'urlAccessToken' => 'https://auth.aweber.com/oauth2/token',
            'urlResourceOwnerDetails' => 'https://api.aweber.com/1.0/accounts',
            'scopes' => 'account.read list.read subscriber.read subscriber.write'
        ]);

        $authorizationUrl = $provider->getAuthorizationUrl();

        // Store the OAuth state parameter for security verification
        session(['oauth2state' => $provider->getState()]);

        return redirect($authorizationUrl);
    }

    function callback(Request $request)
    {
        $provider = new GenericProvider([
            'clientId' => 'unj7Pu5Wz8HAcmnkdbExUBN8W99n796H',
            'clientSecret' => 'DXYDHdcRVTmQk0mCPZlixnH5g2f2CzBv',
            // 'redirectUri' => 'http://127.0.0.1:8000/login/aweber/callback',
            'redirectUri' => 'http://127.0.0.1:8000/aweber/callback',
            'urlAuthorize' => 'https://auth.aweber.com/oauth2/authorize',
            'urlAccessToken' => 'https://auth.aweber.com/oauth2/token',
            'urlResourceOwnerDetails' => 'https://api.aweber.com/1.0/accounts',
        ]);

        $code = $request->query('code');

        // Exchange the authorization code for an access token
        $newAccessToken = $provider->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        $envFilePath = base_path('.env');
        $envContent = file_get_contents($envFilePath);

        // Update the access token value
        $oldAccessToken = env('AWEBER_ACCESS_TOKEN');
        if ($oldAccessToken !== $newAccessToken) {
            $envContent = str_replace(
                'AWEBER_ACCESS_TOKEN=' . $oldAccessToken,
                'AWEBER_ACCESS_TOKEN=' . $newAccessToken,
                $envContent
            );
        }

        // Save the changes back to the .env file
        file_put_contents($envFilePath, $envContent);
        return redirect('/dashboard');
    }

    public function getAweberAccounts()
    {
        $url = "https://api.aweber.com/1.0/accounts/";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $accounts = $response->json();

            if (count($accounts['entries']) > 0) {
                return response()->json($accounts['entries'][0]);
            } else {
                return "No Accounts";
            }
        } else {
            // Handle the error response from AWeber
            $error = $response->json();
            return $error;
            // Handle the error response
            // ...
        }
    }
    public function getAweberList()
    {
        $data = $this->getAweberAccounts();
        $account = json_decode($data->getContent(), true);
        $url = $account['lists_collection_link'];
        $response = Http::withHeaders([
            'User-Agent' => 'AWeber-PHP-code-sample/1.0',
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $list = $response->json();
            return response()->json($list['entries'][2]);
        } else {
            $error = $response->json();
            return $error;
        }
    }
    public function getAweberContacts()
    {
        $data = $this->getAweberList();
        $list = json_decode($data->getContent(), true);
        $url = $list['subscribers_collection_link'];
        $response = Http::withHeaders([
            'User-Agent' => 'AWeber-PHP-code-sample/1.0',
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $body = $response->getBody();
            $contacts = json_decode($body, true);
            return view('contents.aweber', ['contacts' => $contacts['entries']]);
        } else {
            $error = $response->json();
            return $error;
        }
    }

    function deleteAweberSubscriber($id)
    {
        $data = $this->getAweberList();
        $list = json_decode($data->getContent(), true);
        $url = $list['subscribers_collection_link'] . "/" . $id;

        // $url = "https://api.aweber.com/1.0/accounts/1643136/lists/5844925/subscribers;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->delete($url);

        if ($response->successful()) {
            echo 'Subscriber deleted successfully.';
        } else {
            echo 'Request failed. Status code: ' . $response->status();
        }
    }
}
