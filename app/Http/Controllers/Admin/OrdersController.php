<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrdersRequest;
use App\Http\Requests\Admin\UpdateOrdersRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('order_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('order_delete')) {
                return abort(401);
            }
            $orders = Order::onlyTrashed()->get();
        } else {
            $orders = Order::all();
        }

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating new Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('order_create')) {
            return abort(401);
        }
        
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $clients = \App\Cliente::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.orders.create', compact('companies', 'clients'));
    }

    /**
     * Store a newly created Order in storage.
     *
     * @param  \App\Http\Requests\StoreOrdersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrdersRequest $request)
    {
        if (! Gate::allows('order_create')) {
            return abort(401);
        }
        $order = Order::create($request->all());



        return redirect()->route('admin.orders.index');
    }


    /**
     * Show the form for editing Order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('order_edit')) {
            return abort(401);
        }
        
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $clients = \App\Cliente::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $order = Order::findOrFail($id);

        return view('admin.orders.edit', compact('order', 'companies', 'clients'));
    }

    /**
     * Update Order in storage.
     *
     * @param  \App\Http\Requests\UpdateOrdersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrdersRequest $request, $id)
    {
        if (! Gate::allows('order_edit')) {
            return abort(401);
        }
        $order = Order::findOrFail($id);
        $order->update($request->all());



        return redirect()->route('admin.orders.index');
    }


    /**
     * Display Order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('order_view')) {
            return abort(401);
        }
        
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $clients = \App\Cliente::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$scores = \App\Score::where('order_id', $id)->get();

        $order = Order::findOrFail($id);

        return view('admin.orders.show', compact('order', 'scores'));
    }


    /**
     * Remove Order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('order_delete')) {
            return abort(401);
        }
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index');
    }

    /**
     * Delete all selected Order at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('order_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Order::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('order_delete')) {
            return abort(401);
        }
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return redirect()->route('admin.orders.index');
    }

    /**
     * Permanently delete Order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('order_delete')) {
            return abort(401);
        }
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();

        return redirect()->route('admin.orders.index');
    }
}
