<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(CreateOrderRequest $request)
    {
        if (Order::create([
            "customer" => $request->name,
            "company_name" => $request->company_name,
            'country' => $request->country,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'post_code' => $request->post_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'total' => $request->total,
            'products' => json_encode($request->products),
            'status' => 'pending'
        ])) {
            return response()->json([
                'status' => 'success',
                'message' => 'Your request has been saved successfully. Our representative will contact you soon.',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unfortunately, an error occurred while saving your request. Please try again.',
            'data' => [],
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $order = Order::findOrFail($request->id);

        if ($order->status != $request->status) {

            $status = $order->status;
            $order->status = $request->status;
            if ($order->save()) {
                if (($request->status == 'in the way' || $request->status == 'delivered') && ($status == 'pending')) {
                    $this->removeFromStock($order);
                } elseif ($request->status == 'pending') {
                    $this->returnToStock($order);
                }
                return redirect()->back()->with('success', 'Order Status Updated Successfully');
            }
            return redirect()->back()->with('error', 'An error occurred while saving, please try again');
        }

        return redirect()->back()->with('success', 'Order Status Updated Successfully');
    }

    public function removeFromStock(Order $order)
    {
        $products = json_decode($order->products);
        foreach ($products as $product){
            Stock::where(['product_id'=>$product->product_id,'size_id'=>$product->size_id])->decrement('quantity', $product->quantity);
        }

    }

    public function returnToStock(Order $order)
    {
        $products = json_decode($order->products);
        foreach ($products as $product){
            Stock::where(['product_id'=>$product->product_id,'size_id'=>$product->size_id])->increment('quantity', $product->quantity);
        }
    }


    public function destroy(Request $request)
    {


        if (Order::findOrFail($request->id)->delete()) {
            return redirect()->back()->with('success', 'Order Deleted Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while deleting, please try again');
    }
}
