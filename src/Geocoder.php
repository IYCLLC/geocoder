<?php
namespace IYC\Geocoder;

use GuzzleHttp\Client;
use IYC\Geocoder\Exceptions\LocationNotFoundException;

class Geocoder extends BaseGoogleApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';
    }

    /**
     * @param string $address
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException]
     */
    public function getCoordinatesForAddress(string $address): array
    {
        if (empty($address)) {
            throw new LocationNotFoundException();
        }

        $payload = $this->getRequestPayload(compact('address'));
        $response = $this->client->request('GET', $this->endpoint, $payload);
        
        if ($response->getStatusCode() !== 200) {
            throw new LocationNotFoundException();
        }
        
        $geocodingResponse = json_decode($response->getBody());
        
        if (!empty($geocodingResponse->error_message)) {
            throw new LocationNotFoundException($geocodingResponse->error_message);
        }
        
        if (!count($geocodingResponse->results)) {
            throw new LocationNotFoundException();
        }
        
        return $this->formatResponse($geocodingResponse);
    }

    /**
     * @param float $lat
     * @param float $lng
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAddressForCoordinates(float $lat, float $lng): array
    {
        $payload = $this->getRequestPayload([
            'latlng' => "$lat,$lng",
        ]);
        $response = $this->client->request('GET', $this->endpoint, $payload);
        
        if ($response->getStatusCode() !== 200) {
            throw CouldNotGeocode::couldNotConnect();
        }
        
        $reverseGeocodingResponse = json_decode($response->getBody());
        
        if (!empty($reverseGeocodingResponse->error_message)) {
            throw new LocationNotFoundException($reverseGeocodingResponse->error_message);
        }
        
        if (!count($reverseGeocodingResponse->results)) {
            throw new LocationNotFoundException();
        }
        
        return $this->formatResponse($reverseGeocodingResponse);
    }
}