<?php
namespace IYC\Geocoder\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Address extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->resource['place_id'],
            'latitude'   => $this->resource['lat'],
            'longitude'  => $this->resource['lng'],
            'address'    => $this->resource['formatted_address'],
            'name'       => $this->resource['address_components'][0]->long_name ?? '',
        ];
    }
}