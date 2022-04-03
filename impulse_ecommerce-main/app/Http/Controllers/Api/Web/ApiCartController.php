<?php

namespace App\Http\Controllers\Api\Web;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Http\Resources\CartResource;
use App\Http\Requests\CartRequest;
use App\Http\Requests\singleAddToCartRequest;

class ApiCartController extends Controller
{

    public function addToCart(Request $request)
    {
        if (empty($request->slug)) {
            //     // request()->session()->flash('error', 'Invalid Products');
            return 'Invalid Products';
        }
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            // request()->session()->flash('error', 'Invalid Products');
            // return back();
            return 'Invalid Products';
        }
        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if ($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return 'Stock not sufficient!.';

            $already_cart->save();
            return ('Updated');
        } else {

            $user_id = Auth::user()->id;
            $product_id = $product->id;
            $quantity = 1;

            $cart = Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'price' => ($product->price - ($product->price * $product->discount) / 100),
                'quantity' => $quantity,
                'amount' => $product->price * $quantity,

            ]);
            if ($product->stock < $quantity || $product->stock <= 0) {
                return 'Stock not sufficient!';
            }
            return CartResource::make($cart);
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }

        return ('Product added');
    }


    public function singleAddToCart(Request $request)
    {
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);

        $product = Product::where('slug', $request->slug)->first();
        if ($product->stock < $request->quant[1]) {
            // return back()->with('error', 'Out of stock, You can add other products.');
            return ('You can add other products');
        }
        if (($request->quant[1] < 1) || empty($product)) {
            // request()->session()->flash('error', 'Invalid Products');
            // return back();
            return ('Invalid Products');
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                // return back()->with('error', 'Stock not sufficient!.');
                return ('Stock not sufficient!.');
            }
            $already_cart->save();
        } else {


            $user_id = Auth::user()->id;
            $product_id = $product->id;
            $quantity  = $request->quant[1];

            $cart = Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'price' => ($product->price - ($product->price * $product->discount) / 100),
                'quantity' => $quantity,
                'amount' => $product->price * $quantity,

            ]);
            if ($product->stock < $quantity || $product->stock <= 0) {
                return 'Stock not sufficient!';
            }
            return CartResource::make($cart);
        }
        // request()->session()->flash('success', 'Product successfully added to cart.');
        // return back();

        return ('Product added');
    }


    public function cart_update(Request $request)
    {
        // dd($request->all());
        if ($request->quant) {
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k => $quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if ($quant > 0 && $cart) {
                    // return $quant;

                    if ($cart->product->stock < $quant) {
                        // request()->session()->flash('error', 'Out of stock');
                        // return back();
                        return ('Out of stock');
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;

                    if ($cart->product->stock <= 0) continue;
                    $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cart successfully updated!';
                } else {
                    $error[] = 'Cart Invalid!';
                }
            }
            // return back()->with($error)->with('success', $success);
            return ($success);
        } else {
            // return back()->with('Cart Invalid!');
            return ('error');
        }
        // $cart = Cart::find($id);
        // $cart->update($request->all());
        // return $cart;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            // request()->session()->flash('success', 'Cart successfully removed');
            // return back();

            return 'success';
        }
        // request()->session()->flash('error', 'Error please try again');
        // return back();
        return 'error';
    }
}
