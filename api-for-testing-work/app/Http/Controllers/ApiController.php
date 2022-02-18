<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Payment;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function products(Request $request){
        if($request->has('category')){
            $products = Products::where('category_id', $request->category);
        }else{
            $products = Products::all();
        }
        return response()->json([
           'products' => $products
        ]);
    }


    public function save_to_card(Request $request){
        $user = Auth::user();
        $products = $request->products;
        foreach ($products as $product){
            $card = new Card();
            $card->product_id = $product['product_id'];
            $card->user_id = $user->id;
            $card->count = $product['count'];
            $card->save();
        }

        return response()->json([
            'success'=>true,
            'message'=>"Products saved successfully to card!"
        ]);
    }

    public function pay(Request $request){
        $products = $request->products;
        foreach ($products as $product){
            $payment= new Payment();
            $payment->product_id = $product["product_id"];
            $payment->user_id = \auth()->user()->id;
            $payment->count = $product["count"];
            $payment->total_price = $product["price"];
            $payment->total_price = $product["price"];
            $payment->type_payment = $product["type_payment"];
            $payment->save();
        }

        return response()->json([
           'success'=>true,
           'message'=>"Pay successfully!"
        ]);
    }

}
