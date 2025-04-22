<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\Addresses\AdressesResource;
use App\Http\Resources\Front\AddressResource;
use App\Http\Resources\Front\ClientResource;
use App\Models\City;
use App\Models\ClientAddress;
use App\Models\Country;
use App\Models\Product;
use App\Repositories\Front\AddressRepository;
use App\Repositories\Front\ProductRepository;
use App\Traits\ApiResponseAble;
use Faker\Provider\ar_EG\Address;

class AddressService
{
    use FileUpload, ApiResponseAble;

    private $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function create($data)
    {
        $data['client_id']  = auth('client')->id();
        $data['country_id'] = City::find($data['city_id'])->region?->country?->id ?? $data['country_id'] ?? "";
        $address = $this->addressRepository->create($data);
        if( ($data['is_default']  && $data['is_default'] == 1 )|| auth('client')->user()->client_addresses()->count() == 1)
        {
            $this->setDefault($address->id);
            $address->is_default = 1;
        }


        $address = new AddressResource($address);

        return $this->createdResponse($address);
    }


    public function update($data, $address_id)
    {
        $data['client_id']  = auth('client')->id();
        $data['country_id'] = City::find($data['city_id'])->region?->country?->id ?? $data['country_id'] ?? "";
        $address = ClientAddress::find($address_id);
        $data['is_default'] =  $address->is_default;

        if(!$address || $address->client_id !=  auth('client')->id())
        {
            return $this->ApiErrorResponse(null, trans('api.address.address_not_found'));
        }

        $address = $this->addressRepository->update($data, $address->id);


        $address = new AddressResource($address);

        return $this->createdResponse($address);
    }

    public function delete( $address_id)
    {
        $address = ClientAddress::find($address_id);

        if(!$address || $address->client_id !=  auth('client')->id())
        {
            return $this->ApiErrorResponse(null, trans('api.address.address_not_found'));
        }

        if($address->is_default == 1)
        {
            return $this->ApiErrorResponse(null, trans('api.address.cannot_delete_default'));
        }

        $address = $this->addressRepository->delete($address_id);


        return $this->ApiSuccessResponse();
    }

    public function setDefault($address_id)
    {
        $this->addressRepository->setDefault($address_id);
        return $this->ApiSuccessResponse();
    }

    public function getCurrentUserAddresses()
    {
        $addresses = $this->addressRepository->getByUserId(auth('client')->id());
        return $this->listResponse(new AdressesResource($addresses));
    }

}
