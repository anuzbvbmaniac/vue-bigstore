<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return JsonResponse
     * // get all the product records and return them
     */
    public function index(){
        return response()->json(Product::all(), 200); // Status: Ok
    }

    public function create(){
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * // create product record
     */
    public function store(Request $request){
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'units' => $request->units,
            'price' => $request->price,
            'image' => $request->image
        ]);

        return response()->json([
            'status' => (bool) $product,
            'data' => $product,
            'message' => $product ? 'Product Created' : 'Error Creating Product'
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * // fetch and return a single product.
     */
    public function show(Product $product){
        return response()->json($product, 200); // Status : Ok
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * // uploads the imf for a product we created and return the url of the product
     */
    public function uploadFile(Request $request) {
        if($request->hasFile('image')) {
            $name = time()."_".$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $name);
        }
        return response()->json(asset("images/".$name), 201);
    }

    public function edit(Product $product){
        //
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     * // update product record
     */
    public function update(Request $request, Product $product){
        $status = $product->update(
            $request->only(['name', 'description', 'units', 'price', 'image'])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated' : 'Error Updating Product'
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     * // adds new unit to a product.
     */
    public function updateUnits(Request $request, Product $product) {
        $product->units = $product->units + $request->get('units');
        $status = $product->save();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     * // delete the product
     */
    public function destroy(Product $product){
        $status = $product->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
        ]);
    }
}
