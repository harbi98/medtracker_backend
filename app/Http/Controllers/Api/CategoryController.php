<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        if($categories->count() > 0) {
            return response()->json([
                    'status' => 200,
                    'data' => $categories,
                    'message' => 'Success'
                ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'data' => $categories,
                'message' => 'No Records Found'
            ], 404);
        }
    }
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);    
        } else {
            $product = Category::create([
                'name' => $request->name,
            ]);
            if($product) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Added Successfully!',
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
        $category = Category::find($id);
        if($category) {
            return response()->json([
                'status' => 200,
                'data' => $category,
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
        $category = Category::find($id);
        if($category) {
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category Deleted Succesfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Category Found'
            ], 404);
        }
    }
}
