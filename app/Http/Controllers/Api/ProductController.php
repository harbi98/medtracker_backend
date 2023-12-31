<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        if($products->count() > 0) {
            return response()->json([
                    'status' => 200,
                    'data' => $products,
                    'message' => 'Success'
                ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'data' => $products,
                'message' => 'No Records Found'
            ], 404);
        }
    }
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'category_id' => 'required',
            'quantity' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);    
        } else {
            $product = Product::create([
                'name' => $request->name,
                'details' => $request->details,
                'price' => $request->price,
                'photo' => $request->photo,
                'category_id' => $request->category_id,
                'quantity' => $request->quantity,
            ]);
            if($product) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product Added Successfully!',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong!'
                ], 500);
            }
        }
    }
    public function show($id) {
        $product = Product::find($id);
        if($product) {
            return response()->json([
                'status' => 200,
                'data' => $product,
                'message' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'data' => [],
                'message' => 'No Records Found'
            ], 404);
        }
    }
    public function update() {

    }
    public function destroy($id) {
        $product = Product::find($id);
        if($product) {
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Product Deleted Succesfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Product Found'
            ], 404);
        }
    }
}
