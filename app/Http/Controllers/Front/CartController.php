<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Cart\AddShippingAddressRequest;
use App\Http\Requests\Front\Cart\AddToCartRequest;
use App\Http\Requests\Front\Cart\RemoveFromCartRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Services\Front\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public $cartService;

    /**
     * Category  Constructor.
     */
    public function __construct(CartService $cartService)
    {
        $this->middleware('auth:client');
        $this->cartService = $cartService;
    }

    public function addToCart(AddToCartRequest $request)
    {
        return $this->cartService->addToCart($request->validated());
    }

    // public function updateCartItem(Request $request, $cartItemId)
    // {
    //     $cartItem = Cart::find($cartItemId);

    //     if (!$cartItem) {
    //         return redirect()->back()->with('error', 'Cart item not found.');
    //     }

    //     $quantity = $request->input('quantity');

    //     if ($quantity <= 0) {
    //         // Remove the item from the cart if quantity is zero or negative
    //         $cartItem->delete();
    //     } else {
    //         // Update the quantity
    //         $cartItem->quantity = $quantity;
    //         $cartItem->save();
    //     }

    //     return redirect()->route('cart.index')->with('success', 'Cart updated.');
    // }

    public function removefromCart(RemoveFromCartRequest $request)
    {
        return $this->cartService->removeFromCart($request->validated());
    }

    public function emptyCart(Request $request)
    {
        return $this->cartService->removeAllFromCart();
    }

    public function getCurrentCart(Request $request)
    {
        return $this->cartService->getCurrentCart();
    }

    public function getCartItems()
    {
        return $this->cartService->getCartItems();
    }


    public function addShippingAddress(AddShippingAddressRequest $request)
    {
        return $this->cartService->addShippingAddress($request->validated());
    }


}
