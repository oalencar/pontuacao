<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderStatus;
use App\Partner;
use App\Score;
use App\EmailMarketing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrdersRequest;
use App\Http\Requests\Admin\UpdateOrdersRequest;

class OrdersController extends Controller
{
    public function __construct(
        OrderStatus $orderStatus,
        Score $score,
        Partner $partner,
        EmailMarketing $emailMarketing
    )
    {
        $this->orderStatus = $orderStatus;
        $this->score = $score;
        $this->partner = $partner;
        $this->emailMarketing = $emailMarketing;
    }

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
        //dd($request->all());
        if (! Gate::allows('order_create')) {
            return abort(401);
        }

        $order = Order::create($request->all());

        // ORDERSTATUS LOGIC
        $orderStatusObservacao = collect($request->get('order-status-observacao'));
        $orderStatusData = collect($request->get('order-status-data'));

        $orderStatuses = $orderStatusData->map(function ($data, $key) use ($order, $orderStatusObservacao) {
            $orderStatus = new $this->orderStatus;

            $orderStatus->observacao = $orderStatusObservacao[$key];
            $orderStatus->data = $data;
            $orderStatus->order_id = $order->id;

            return $orderStatus;
        });

        $order->order_statuses()->saveMany($orderStatuses);

        // SCORE LOGIC
        $scoreUsersIds = collect($request->get('score-user-id'));
        $scoreScores = collect($request->get('score-score'));

        $scoresToSave = $scoreScores->map(function ($score, $key) use ($scoreUsersIds, $order) {
            $newScore = new $this->score;

            $newScore->score = $score;
            $newScore->user_id = $scoreUsersIds[$key];
            $newScore->order_id = $order->id;

            return $newScore;

        });

        $order->scores()->saveMany($scoresToSave);

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

        $orderStatuses = $this->orderStatus::where('order_id', $order->id)->get();
        $scores = $this->score::where('order_id', $order->id)->get();
        $partners = $this->partner::with('user')->where('company_id', $order->company_id)->get();

        return view('admin.orders.edit', compact('order', 'companies', 'clients', 'orderStatuses', 'scores', 'partners'));
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

        // ORDERSTATUS LOGIC
        $orderStatusIds = collect($request->get('order-status-id'));
        $orderStatusObservacao = collect($request->get('order-status-observacao'));
        $orderStatusData = collect($request->get('order-status-data'));


        $orderStatusData->map(function ($data, $key) use ($orderStatusIds, $orderStatusObservacao, $order) {


            if (isset($orderStatusIds[$key])) {

                $orderStatusSaved = $this->orderStatus->find($orderStatusIds[$key]);

                $orderStatusSaved->observacao = $orderStatusObservacao[$key];
                $orderStatusSaved->data = $data;

                $orderStatusSaved->save();
            } else {
                $newOrderStatus = new $this->orderStatus;

                $newOrderStatus->observacao = $orderStatusObservacao[$key];
                $newOrderStatus->data = $data;
                $newOrderStatus->order_id = $order->id;

                $newOrderStatus->save();
            }

        });

        // SCORE LOGIC
        $scoreIds = collect($request->get('score-id'));
        $scoreUsersIds = collect($request->get('score-user-id'));
        $scoreScores = collect($request->get('score-score'));

        $scoreScores->map(function ($score, $key) use ($scoreIds, $scoreUsersIds, $order) {

            if (!isset($scoreIds[$key])) {
                $newScore = new $this->score;

                $newScore->score = $score;
                $newScore->user_id = $scoreUsersIds[$key];
                $newScore->order_id = $order->id;

                $newScore->save();
            }

        });

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


    public function sendEmailOrderRegister($order_id)
    {
        return $this->emailMarketing->sendOrderRegister($order_id);
    }
}
