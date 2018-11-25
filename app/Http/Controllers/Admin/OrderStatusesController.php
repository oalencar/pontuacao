<?php

namespace App\Http\Controllers\Admin;

use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderStatusesRequest;
use App\Http\Requests\Admin\UpdateOrderStatusesRequest;

class OrderStatusesController extends Controller
{
    /**
     * Display a listing of OrderStatus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('order_status_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('order_status_delete')) {
                return abort(401);
            }
            $order_statuses = OrderStatus::onlyTrashed()->get();
        } else {
            $order_statuses = OrderStatus::all();
        }

        return view('admin.order_statuses.index', compact('order_statuses'));
    }

    /**
     * Show the form for creating new OrderStatus.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('order_status_create')) {
            return abort(401);
        }
        return view('admin.order_statuses.create');
    }

    /**
     * Store a newly created OrderStatus in storage.
     *
     * @param  \App\Http\Requests\StoreOrderStatusesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderStatusesRequest $request)
    {
        if (! Gate::allows('order_status_create')) {
            return abort(401);
        }
        $order_status = OrderStatus::create($request->all());



        return redirect()->route('admin.order_statuses.index');
    }


    /**
     * Show the form for editing OrderStatus.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('order_status_edit')) {
            return abort(401);
        }
        $order_status = OrderStatus::findOrFail($id);

        return view('admin.order_statuses.edit', compact('order_status'));
    }

    /**
     * Update OrderStatus in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderStatusesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderStatusesRequest $request, $id)
    {
        if (! Gate::allows('order_status_edit')) {
            return abort(401);
        }
        $order_status = OrderStatus::findOrFail($id);
        $order_status->update($request->all());



        return redirect()->route('admin.order_statuses.index');
    }


    /**
     * Display OrderStatus.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('order_status_view')) {
            return abort(401);
        }
        $order_status = OrderStatus::findOrFail($id);

        return view('admin.order_statuses.show', compact('order_status'));
    }


    /**
     * Remove OrderStatus from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('order_status_delete')) {
            return abort(401);
        }
        $order_status = OrderStatus::findOrFail($id);
        $order_status->delete();

        return redirect()->route('admin.order_statuses.index');
    }

    /**
     * Delete all selected OrderStatus at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('order_status_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = OrderStatus::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore OrderStatus from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('order_status_delete')) {
            return abort(401);
        }
        $order_status = OrderStatus::onlyTrashed()->findOrFail($id);
        $order_status->restore();

        return redirect()->route('admin.order_statuses.index');
    }

    /**
     * Permanently delete OrderStatus from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('order_status_delete')) {
            return abort(401);
        }
        $order_status = OrderStatus::onlyTrashed()->findOrFail($id);
        $order_status->forceDelete();

        return redirect()->route('admin.order_statuses.index');
    }
}
