<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Create a new cart controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'show',
            'store',
            'update',
            'delete'
        ]]);
    }


    /**
     * Get an existing Cart, including cart items.
     *
     * @return object
     */
    public function show(Request $request, $id)
    {
        /**
         * Ensure that the current can access this cart.
         */
        $apiKey = $request->header('x-api-key');
        $user = DB::table('Users')->where('key', $apiKey)->first();
        $cart = DB::table('Carts')->where('id', $id)->first();
        if ($cart->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401, ['x-api-key' => $apiKey]);
        }

        $cartItems = DB::table("CartItems")->where('cart_id', $id)->get();
        return response()->json(["cart" => $cart, "items" => $cartItems]);
    }


    /**
     * Create Cart.
     * @return object
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|string'
        ]);

        $apiKey = $request->header('x-api-key');
        $user = DB::table('Users')->where('key', $apiKey)->first();

        $data = $request->all();
        $data["enabled"] = true;
        $data["user_id"] = $user->id;
        $data["date_created"] = time();
        $id = DB::table('Carts')->insertGetId($data);
        return response()->json(['id' => $id]);
    }

    /**
     * Update existing cart
     *
     * @return object
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'customer_id' => 'required|string'
        ]);
        $customer_id = $request->input('customer_id');
        $id = DB::update("UPDATE Carts SET customer_id = ? WHERE id = ?", [$customer_id, $id]);
        return response()->json(['success' => "true"]);
    }

    /**
     * Delete Cart and associated Cart Items.
     *
     * @return object
     */
    public function delete($id)
    {
        DB::delete('delete from CartItems where cart_id = ?', [$id]);
        DB::delete('delete from Carts where id = ?', [$id]);
        return response()->json(['success' => "true"]);
    }
}
