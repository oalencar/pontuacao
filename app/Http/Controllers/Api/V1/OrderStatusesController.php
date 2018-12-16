<?php

namespace App\Http\Controllers\Api\V1;

use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderStatusesRequest;
use App\Http\Requests\Admin\UpdateOrdersStatusesRequest;

class OrderStatusesController extends Controller
{
    public function index()
    {
        return OrderStatus::all();
    }

    public function show($id)
    {
        return OrderStatus::findOrFail($id);
    }

    public function update(UpdateOrderStatusesRequest $request, $id)
    {
        $order = OrderStatus::findOrFail($id);
        $order->update($request->all());


        return $order;
    }

    public function store(StoreOrderStatusesRequest $request)
    {
        $order = OrderStatus::create($request->all());


        return $order;
    }

    public function destroy($id)
    {
        $order = OrderStatus::findOrFail($id);
        $order->delete();
        return '';
    }
}
