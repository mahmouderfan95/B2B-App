<?php

namespace App\Repositories\Shipping;

use App\Enums\OfferStatus;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Models\ShippingOffer;
use Prettus\Repository\Eloquent\BaseRepository;

class OfferRepository extends BaseRepository
{

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->where('shipping_method_id',auth()->user()->id)
        ->where('special_order_id',null)
        ->get();
    }

    public function getOrders()
    {
        return Order::where('status',OrderStatus::READY_TO_SHIP)->get();
    }

    public function createOffer($data)
    {
        $offer = $this->model->create([
            'shipping_method_id' => auth('shipping')->user()->id,
            'order_id' => $data['order_id'],
            'price' => $data['price'],
        ]);
        return $offer;
    }
    /**
     * Offer Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\ShippingQuotation";
    }
}
