<?php

namespace App\Http\Controllers;

use App\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * @return JsonResponse
     * // fetches and returns all the orders.
     */
    public function index(){
        return response()->json(Order::with(['product'])->get(),200); // Status : Ok
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * // marks an order as delivered.
     */
    public function deliverOrder(Order $order) {
        $order->isDelivered	= true;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
        ]);
    }

    public function create(){

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * // creates an order.
     */
    public function store(Request $request){
        $order = Order::create([
            'productId' => $request->product_id,
            'userId' => Auth::id(),
            'quantity' => $request->quantity,
            'address' => $request->address
        ]);

        return response()->json([
            'status' => (bool) $order,
            'data'   => $order,
            'message' => $order ? 'Order Created!' : 'Error Creating Order'
        ]);
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * // fetches and returns a single order.
     */
    public function show(Order $order){
        return response()->json($order,200);
    }

    public function edit(Order $order){
        //
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return JsonResponse
     * // updates the order.
     */
    public function update(Request $request, Order $order){
        $status = $order->update(
            $request->only(['quantity'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * @throws Exception
     * // Deletes the order
     */
    public function destroy(Order $order){
        $status = $order->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
        ]);
    }
}
