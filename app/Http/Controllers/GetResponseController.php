<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GetResponseController extends Controller
{
    protected $api_key = "smpohjxrknqrrg6nrnyoluhrs1skgeeq";
    protected $base_url = "https://api.getresponse.com/v3";

    public function getContacts()
    {
        $ch = curl_init($this->base_url . "/contacts");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: api-key ' . $this->api_key,
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function getContact($id)
    {
        $ch = curl_init($this->base_url . "/contacts/" . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: api-key ' . $this->api_key,
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function subscribeContact($id)
    {
        $ch = curl_init($this->base_url . "/contacts/{$id}/subscribe");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: api-key ' . $this->api_key,
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function unsubscribeContact($id)
    {
        $ch = curl_init($this->base_url . "/contacts/" . $id . "/unsubscribe");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: api-key ' . $this->api_key,
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function deleteContact($id)
    {
        $ch = curl_init($this->base_url . "/contacts/" . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: api-key ' . $this->api_key,
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
