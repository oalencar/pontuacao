<?php

namespace App\Http\Controllers\Admin;

use \App\Models\Cliente;
use App\Models\Company;
use App\Models\Order;
use App\OrderStatus;
use App\Partner;
use App\Score;
use App\Services\EmailMarketingService;
use App\Services\ScoreService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrdersRequest;
use App\Http\Requests\Admin\UpdateOrdersRequest;

class OrdersController extends Controller
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var OrderStatus
     */
    private $orderStatus;

    /**
     * @var Score
     */
    private $score;

    /**
     * @var Partner
     */
    private $partner;

    /**
     * @var EmailMarketingService
     */
    private $emailMarketing;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var Cliente
     */
    private $client;

    private $scoreService;

    public function __construct(
        Order $order,
        OrderStatus $orderStatus,
        Score $score,
        Partner $partner,
        EmailMarketingService $emailMarketing,
        Cliente $client,
        Company $company,
        ScoreService $scoreService
    )
    {
        $this->order = $order;
        $this->orderStatus = $orderStatus;
        $this->score = $score;
        $this->partner = $partner;
        $this->emailMarketing = $emailMarketing;
        $this->client = $client;
        $this->company = $company;
        $this->scoreService = $scoreService;
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
            $orders = $this->order::onlyTrashed()->get();
        } else {
            $orders = $this->order::all();
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

        $companies = $this->company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.orders.create', compact('companies'));
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

        $order = $this->order::create($request->all());

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
        $scorePartnersIds = collect($request->get('score-partner-id'));
        $scoreScores = collect($request->get('score-score'));

        $scoresToSave = $scoreScores->map(function ($score, $key) use ($scorePartnersIds, $order) {
            $newScore = new $this->score;

            $newScore->score = str_replace('.', '', $score);
            $newScore->partner_id = $scorePartnersIds[$key];
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

        $order = $this->order::findOrFail($id);

        $orderStatuses = $this->orderStatus::where('order_id', $order->id)->get();
        $scores = $this->score::where('order_id', $order->id)->get();
        $allPartners = $this->partner::with('user', 'partner_type', 'company')->get();
        $partners = $allPartners->filter(function ($partner) use ($order) {
            return $partner->company->id == $order->company_id;
        })->toJson();

        return view('admin.orders.edit', compact('order', 'orderStatuses', 'scores', 'partners'));
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
        $order = $this->order::findOrFail($id);

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
        $scorePartnersIds = collect($request->get('score-partner-id'));
        $scoreScores = collect($request->get('score-score'));

        $scoreScores->each(function ($score, $key) use ($scoreIds, $scorePartnersIds, $order) {

            if (!isset($scoreIds[$key])) {
                $newScore = new $this->score;

                $newScore->score = str_replace('.', '', $score);
                $newScore->partner_id = $scorePartnersIds[$key];
                $newScore->order_id = $order->id;

                $newScore->save();
            }

        });

        $order->update($request->except(['company_id', 'client_id']));

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

        $companies = $this->company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $clients = $this->client::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$scores = \App\Score::where('order_id', $id)->get();

        $order = $this->order::findOrFail($id);

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
        $order = $this->order::findOrFail($id);
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
            $entries = $this->order::whereIn('id', $request->input('ids'))->get();

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
        $order = $this->order::onlyTrashed()->findOrFail($id);
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
        $order = $this->order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();

        return redirect()->route('admin.orders.index');
    }


    public function sendEmailOrderRegister($order_id)
    {
        return $this->emailMarketing->sendOrderRegister($order_id);
    }

    public function sendEmailOrderUpdate($order_id)
    {
        return $this->emailMarketing->sendOrderUpdate($order_id);
    }

    public function sendEmailOrderFinish($order_id)
    {
        return $this->emailMarketing->sendOrderFinished($order_id);
    }
}
