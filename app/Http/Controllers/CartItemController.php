<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
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
     * Get Cart Item.
     *
     * @return string
     */
    public function show($id)
    {
        $results = DB::table("CartItems")->where("id", $id)->first();
        return response()->json(['item' => $results]);
    }


    /**
     * Add Cart Item to cart.
     *
     * @return object
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'cart_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $data = $request->all();

        $data['active'] = true;
        $data['date_added'] = time();
        $id = DB::table('CartItems')->insertGetId($data);
        return response()->json(['id' => $id]);
    }


    /**
     * Update cart item, the only thing you can update is the quantity.
     *
     * @return object
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'quantity' => 'required|integer'
        ]);

        $quantity = $request->input('quantity');
        DB::update('update CartItems set quantity = ? where id = ?', [$quantity, $id]);
        return response()->json(['success' => "true"]);
    }


    /**
     * Delete Cart Item.
     *
     * @return object
     */
    public function delete($id)
    {
        DB::delete('delete from CartItems where id = ?', [$id]);
        return response()->json(['success' => "true"]);
    }
}
