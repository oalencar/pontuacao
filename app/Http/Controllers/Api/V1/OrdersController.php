<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrdersRequest;
use App\Http\Requests\Admin\UpdateOrdersRequest;

class OrdersController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function show($id)
    {
        return Order::findOrFail($id);
    }

    public function update(UpdateOrdersRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());


        return $order;
    }

    public function store(StoreOrdersRequest $request)
    {
        $order = Order::create($request->all());


        return $order;
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return '';
    }
}
