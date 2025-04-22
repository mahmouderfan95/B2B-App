<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Address\CreateAddressRequest;
use App\Services\Front\AddressService;
use App\Services\Front\ProductService;
use Illuminate\Http\Request;


class AddressController extends Controller
{
    public $addressService;

    /**
     * Product  Constructor.
     */
    public function __construct(AddressService $addressService)
    {
        $this->middleware('auth:client');
        $this->addressService = $addressService;
    }

    /**
     *  best seller
     */
    public function store(CreateAddressRequest $request)
    {
        return $this->addressService->create($request->validated());
    }

    public function update(CreateAddressRequest $request, $address_id)
    {
        return $this->addressService->update($request->validated(), $address_id);
    }

    public function delete( $address_id)
    {
        return $this->addressService->delete($address_id);
    }

    public function setDefault($address_id)
    {
        return $this->addressService->setDefault($address_id);
    }

    public function getCurrentUserAddresses()
    {
        return $this->addressService->getCurrentUserAddresses();
    }

}
