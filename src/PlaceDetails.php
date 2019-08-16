<?php
namespace IYC\Geocoder;

use GuzzleHttp\Client;
use IYC\Geocoder\Exceptions\LocationNotFoundException;

class PlaceDetails extends BaseGoogleApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->endpoint = 'https://maps.googleapis.com/maps/api/place/details/json';
    }

    /**
     * @param string $place_id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException]
     */

    public function getPlaceDetailsByPlaceID(string $place_id): array
    {
        if (empty($place_id)) {
            throw new LocationNotFoundException();
        }

        $payload = $this->getRequestPayload(compact('place_id'));
        $response = $this->client->request('GET', $this->endpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            throw new LocationNotFoundException();
        }

        $placeDetailsResponse = json_decode($response->getBody(), true);

        if (!empty($placeDetailsResponse['error_message'])) {
            throw new LocationNotFoundException($placeDetailsResponse['error_message']);
        }

        if (!count($placeDetailsResponse['result'])) {
            throw new LocationNotFoundException();
        }

        return $placeDetailsResponse['result'];
    }
}