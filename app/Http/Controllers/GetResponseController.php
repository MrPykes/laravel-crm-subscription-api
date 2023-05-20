<?php

namespace App\Http\Controllers;

use League\OAuth2\Client\Provider\GenericProvider;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GetResponseController extends Controller
{
    protected $access_token;
    protected $base_url = "https://api.getresponse.com/v3";

    public function __construct()
    {
        $this->access_token = config('getresponse.access_token');
    }

    public function getContacts()
    {
        $url = $this->base_url . '/contacts';
        $client = new Client();
        $response = $client->get($url, [
            'headers' => [
                'X-Auth-Token' => 'api-key ' . $this->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = $response->getBody();
        $contacts = json_decode($body, true);
        return view('contents.getresponse', compact('contacts'));
    }

    public function getContact($id)
    {
        $url = $this->base_url . "/contacts/{$id}";
        $client = new Client();
        $response = $client->get($url, [
            'headers' => [
                'X-Auth-Token' => 'api-key ' . $this->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);
        return $data;
    }

    public function deleteContact($id)
    {
        $url = $this->base_url . "/contacts/{$id}";
        $client = new Client();
        $response = $client->delete($url, [
            'headers' => [
                'X-Auth-Token' => 'api-key ' . $this->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);
        return $data;
    }
}
