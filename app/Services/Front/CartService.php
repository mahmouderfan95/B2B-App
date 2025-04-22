<?php

namespace App\Services\Front;

use App\Exceptions\Cart\cartBadUse;
use App\Exceptions\Cart\ProductExistInCart;
use App\Helpers\FileUpload;
use App\Http\Resources\Front\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Vendor;
use App\Repositories\Front\CartRepository;
use App\Repositories\Front\ProductRepository;
use App\Traits\ApiResponseAble;
use Exception;

class CartService
{
    use FileUpload, ApiResponseAble;

    private $cartRepository;
    private $productRepository;

    public function __construct(CartRepository $cartRepository,
     ProductRepository $productRepository
    )
    {

        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function getCurrentCart($cart = null )
    {

        $cart = $cart ?? $this->getActiveCart(auth('client')->id());
        $cartobj = ($this->cartRepository->getCartItems($cart));
        $cartobj->summary =  $this->cartRepository->getCartSummary($cart);
        return $cartobj;
    }

    public function getCartItems($user_id = null)
    {
        $cart = $this->getCurrentCart();
        // dd($cart);
        return $this->showResponse( new CartResource($cart));
    }

    public function addToCart(array $data)
    {
        $cart = $this->getActiveCart();
        $cartProducts = $this->prepateCartProductData($data['items']);

        $this->checkCartProductValidation($cart, $cartProducts);
        $this->cartRepository->addCartProducts($cart, $cartProducts);
        $cartItems = $this->cartRepository->getCartItems($cart);
        $cartItems->summary =  $this->cartRepository->getCartSummary($cart);

        return $this->updatedResponse(new CartResource($cartItems));
    }

    public function removeFromCart(array $data)
    {
        $cart = $this->getActiveCart(auth('client')->id());
        $this->checkProductsExistsInCart($cart, $data);
        $this->cartRepository->removeCartProducts($cart, $data['product_id']);
        $cartItems = $this->cartRepository->getCartItems($cart);
        $cartItems->summary =  $this->cartRepository->getCartSummary($cart);

        return $this->updatedResponse(new CartResource($cartItems));
    }

    public function removeAllFromCart()
    {
        $cart = $this->getActiveCart(auth('client')->id());

        $this->cartRepository->removeAllCartProducts($cart);
        $cartItems = $this->cartRepository->getCartItems($cart);

        return $this->updatedResponse(CartResource::collection($cartItems));
    }

    private function createCart($client_id,$address)
    {
        return $this->cartRepository->create(
            ['client_id' => $client_id,'client_address_id' => $address]
        );
    }

    private function createNewCart($data)
    {
        $cart = Cart::create([
            'client_id' => $data['client_id'],
            'client_address_id' => $data['client_address_id'],
        ]);
        return $cart;
    }
    public function getActiveCart($client_id = null)
    {
        $client_id = $client_id  ?? auth('client')->id();
        return $this->cartRepository->getCartByClient($client_id)??
        $this->createCart($client_id,request('client_address_id'));
    }

    private function prepateCartProductData($items)
    {
        $cartProduct = [];
        foreach($items as $item){
            $vendor_id = Product::find($item['product_id'])->vendor_id;
            $cartProduct[]=[
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'vendor_id'  => $vendor_id,
            ];
        }
        return $cartProduct;
    }
    private function checkCartProductValidation($cart, $cartItems)
    {
        $cartProducts    = $cart->cartProduct;
        $cartProductsIds = $cartProducts->pluck('product_id')->toArray();
        $cartVendorsIds  = $cartProducts->pluck('vendor_id')->toArray();

        foreach($cartItems as $item)
        {

            if(in_array($item['product_id'],  $cartProductsIds))
            {
                throw new cartBadUse(__('api.cart.product_already_exists'), 400);
            }
            // if(!in_array($item['vendor_id'],  $cartVendorsIds) && !empty($cartVendorsIds))
            // {
            //     throw new cartBadUse('cannot add product from another vendor', 400);
            // }
            $item = Product::find($item['product_id']);
            if($item->status != "accepted" )
            {
                throw new cartBadUse(__('api.cart.product_unavailable'), 400);
            }
            if($item->sample_order_quantity <= 0)
            {
                throw new cartBadUse(__('api.cart.product_no_quantity'), 400);
            }
        }

        foreach($cartProducts  as $item)
        {
            if($item->status != "accepted" || $item->sample_order_quantity <= 0)
            {
                // throw new cartBadUse(__('api.cart.product_unavailable'), 400);
            }

        }
    }

    private function checkProductsExistsInCart($cart, $cartItems)
    {
        $cartProducts    = $cart->cartProduct;
        $cartProductsIds = $cartProducts->pluck('product_id')->toarray();
        foreach($cartItems['product_id'] as $item)
        {
            if(!in_array($item,  $cartProductsIds))
            {
                throw new cartBadUse('Custom error message', 400);
            }
        }
    }

    public function addShippingAddress($data)
    {
        $cart = $this->getActiveCart(auth('client')->id());
        return $this->cartRepository->update([
            'client_address_id' => $data['address_id'],
        ],  $cart->id);
        return $this->updatedResponse([]);
    }

}
