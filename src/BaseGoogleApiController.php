<?php
namespace IYC\Geocoder;

use GuzzleHttp\Client;
use IYC\Geocoder\Exceptions\LocationNotFoundException;

Abstract class BaseGoogleApiController
{
    const RESULT_NOT_FOUND = 'result_not_found';

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var string */
    protected $endpoint;

    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $language;

    /** @var string */
    protected $region;

    /** @var string */
    protected $bounds;

    /** @var string */
    protected $country;

    /**
     * Geocoder constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param string $region
     * @return $this
     */
    public function setRegion(string $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @param string $bounds
     * @return $this
     */
    public function setBounds(string $bounds)
    {
        $this->bounds = $bounds;

        return $this;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param $response
     * @return array
     */
    protected function formatResponse($response): array
    {
        return [
            'lat' => $response->results[0]->geometry->location->lat,
            'lng' => $response->results[0]->geometry->location->lng,
            'accuracy' => $response->results[0]->geometry->location_type,
            'formatted_address' => $response->results[0]->formatted_address,
            'viewport' => $response->results[0]->geometry->viewport,
            'address_components' => $response->results[0]->address_components,
            'place_id' => $response->results[0]->place_id
        ];
    }

    /**
     * @param array $parameters
     * @return array
     */
    protected function getRequestPayload(array $parameters): array
    {
        $parameters = array_merge([
            'key' => $this->apiKey,
            'language' => $this->language,
            'region' => $this->region,
            'bounds' => $this->bounds,
        ], $parameters);

        if ($this->country) {
            $parameters = array_merge(
                $parameters,
                ['components' => 'country:'.$this->country]
            );
        }

        return ['query' => $parameters];
    }
}