<?php

namespace App\Services\Shipping;

use App\Helpers\FileUpload;
use App\Models\ShippingOffer;
use App\Repositories\Shipping\OfferRepository;
use Exception;
use Illuminate\Http\Request;

class OfferService
{

    use FileUpload;

    private $offerRepository;
    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     *
     * All  public_offers.
     *
     */
    public function index($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $offers = $this->offerRepository->index($request);
            return view("shipping.offers.index", compact('offers'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function create()
    {
        $orders = $this->offerRepository->getOrders();
        return view('shipping.offers.create',compact('orders'));
    }

    public function store(Request $request)
    {
        try{
            $createOffer = $this->offerRepository->createOffer($request->all());
            return redirect()->route('shipping.offers.index');
        }catch (\Exception $exception){
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


}
