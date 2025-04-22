<?php

namespace App\Services\Front;

use App\Http\Resources\Front\Drafts\GetDraftDataResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Traits\ApiResponseAble;
class DraftServices{
    use ApiResponseAble;
    public function getDraftData()
    {
        //code
        $user = auth('client')->user();
        $cart = $this->getCartByUserId($user->id);
        if(!$cart){
            return $this->errorResponse(false,400,'Cart not found');
        }
        $products = CartProduct::where('cart_id',$cart->id)->paginate(10);

        return $this->listResponse(new GetDraftDataResource($products));
    }

    private function getCartByUserId($id)
    {
        $cart = Cart::where('client_id',$id)->first();
        return $cart;
    }
}
