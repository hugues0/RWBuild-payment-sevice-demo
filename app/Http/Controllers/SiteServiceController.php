<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SiteServiceController extends Controller
{

    public $token;

    public function __construct()
    {
        $response = Http::asForm()->post('https://test.siteservices.murugocloud.com/oauth/token',[
            'grant_type'=>'client_credentials',
            'client_id'=>env('SS_CLIENT_ID'),
            'client_secret'=>env('SS_CLIENT_SECRET'),
            'scope'=>'',
        ]);

        $this->token=$response->json()['access_token'];
    }

    /**
     * this function fetches a location based on provided key and entry
     */
    public function searchLocation()
    {
        $response=Http::withHeaders([
            'accept'=>'application/json',
            'Authorization'=>'Bearer '.$this->token
        ])->asForm()->post('https://test.siteservices.murugocloud.com/api/v2/search-location',[
            'key'=>'name',
            'entry'=> 'Inema Arts Center'
        ]);

        return $response->json();
    }

    /**
     * This function fetches an organization based on provided entry
     */
    public function searchOrganization()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->asForm()->post('https://test.siteservices.murugocloud.com/api/v2/search-organizations', [
            'entry' => 'Klab',
        ]);

        return $response->json();
    }

    /**
     * This function returns an array of all approved organizations
     */
    public function getApprovedOrganizations()
    {
        $response=Http::withHeaders([
            'Accept'=>'application/json',
            'Authorization' => 'Bearer '.$this->token
        ])->get('https://test.siteservices.murugocloud.com/api/v2/paginated-organizations');
        
        return $response->json();
    }

    /**
     * This function returns an array of all approved locations
     */
    public function getApprovedLocations()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->get('https://test.siteservices.murugocloud.com/api/v2/paginated-locations');

        return $response->json();
    }

}
