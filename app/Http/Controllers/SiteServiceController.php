<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SiteServiceController extends Controller
{

    public array $headers;

    public function __construct()
    {
        $response = Http::asForm()->post('https://test.siteservices.murugocloud.com/oauth/token',[
            'grant_type'=>'client_credentials',
            'client_id'=>env('SS_CLIENT_ID'),
            'client_secret'=>env('SS_CLIENT_SECRET'),
            'scope'=>'',
        ]);

        $this->headers = array('Accept'=> 'application/json','Authorization'=>'Bearer '.$response->json()['access_token']);
    }

    /**
     * this function fetches a location based on provided key and entry
     */
    public function searchLocation()
    {
        $response=Http::withHeaders($this->headers)
            ->asForm()
            ->post(env('SS_BASE_URL').'search-location',[
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
        $response = Http::withHeaders($this->headers)
        ->asForm()
        ->post(env('SS_BASE_URL').'search-organizations', [
            'entry' => 'Klab',
        ]);

        return $response->json();
    }

    /**
     * This function returns an array of all approved organizations
     */
    public function getApprovedOrganizations()
    {
        $response=Http::withHeaders($this->headers)
        ->get(env('SS_BASE_URL').'paginated-organizations');
        
        return $response->json();
    }

    /**
     * This function returns an array of all approved locations
     */
    public function getApprovedLocations()
    {
        $response = Http::withHeaders($this->headers)
        ->get(env('SS_BASE_URL').'paginated-locations');

        return $response->json();
    }

    /**
     * This function is for submitting an organization
     */
    public function submitOrganization()
    {
        $response = Http::withHeaders($this->headers)
        ->asForm()
        ->post(env('SS_BASE_URL') . 'submit-organization', [
            'murugo_location_id' => 1378,
            'name'=>'papa John'
        ]);

        return $response->json();
    }

}
