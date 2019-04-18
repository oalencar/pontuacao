<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Order;
use App\PartnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompaniesRequest;
use App\Http\Requests\Admin\UpdateCompaniesRequest;

/**
 * Class CompaniesController
 * @package App\Http\Controllers\Admin
 */
class CompaniesController extends Controller
{
    /**
     * @var Company
     */
    private $company;
    /**
     * @var PartnerType
     */
    private $partnerType;
    /**
     * @var Order
     */
    private $order;
    /**
     * @var Cliente
     */
    private $client;
    /**
     * @var Award
     */
    private $award;

    /**
     * CompaniesController constructor.
     * @param Company $company
     * @param PartnerType $partnerType
     * @param Order $order
     * @param Cliente $client
     * @param Award $award
     */
    public function __construct(
        Company $company,
        PartnerType $partnerType,
        Order $order,
        Cliente $client,
        Award $award
    ) {
        $this->company = $company;
        $this->partnerType = $partnerType;
        $this->order = $order;
        $this->client = $client;
        $this->award = $award;
    }

    /**
     * Display a listing of Company.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('company_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('company_delete')) {
                return abort(401);
            }
            $companies = $this->company->onlyTrashed()->get();
        } else {
            $companies = $this->company->all();
        }

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating new Company.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('company_create')) {
            return abort(401);
        }
        return view('admin.companies.create');
    }

    /**
     * Store a newly created Company in storage.
     *
     * @param  \App\Http\Requests\StoreCompaniesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompaniesRequest $request)
    {
        if (! Gate::allows('company_create')) {
            return abort(401);
        }
        $company = $this->company->create($request->all());

        foreach ($request->input('awards', []) as $data) {
            $company->awards()->create($data);
        }
        return redirect()->route('admin.companies.index');
    }


    /**
     * Show the form for editing Company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('company_edit')) {
            return abort(401);
        }

        $partner_types = \App\PartnerType::where('company_id', $id)->get();
        $orders = \App\Models\Order::where('company_id', $id)->get();
        $clientes = \App\Models\Cliente::where('company_id', $id)->get();
        $awards = \App\Models\Award::where('company_id', $id)->get();

        $company = $this->company->findOrFail($id);

        $partners = $company->partners()->get();


        return view('admin.companies.edit', compact('company', 'partners', 'partner_types', 'orders', 'clientes', 'awards'));
    }

    /**
     * Update Company in storage.
     *
     * @param  \App\Http\Requests\UpdateCompaniesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompaniesRequest $request, $id)
    {
        if (! Gate::allows('company_edit')) {
            return abort(401);
        }
        $company = $this->company->findOrFail($id);
        $company->update($request->all());

        $awards           = $company->awards;
        $currentAwardData = [];
        foreach ($request->input('awards', []) as $index => $data) {
            if (is_integer($index)) {
                $company->awards()->create($data);
            } else {
                $id                          = explode('-', $index)[1];
                $currentAwardData[$id] = $data;
            }
        }
        foreach ($awards as $item) {
            if (isset($currentAwardData[$item->id])) {
                $item->update($currentAwardData[$item->id]);
            } else {
                $item->delete();
            }
        }


        return redirect()->route('admin.companies.index');
    }


    /**
     * Display Company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('company_view')) {
            return abort(401);
        }
        $partner_types = \App\PartnerType::where('company_id', $id)->get();
        $orders = \App\Models\Order::where('company_id', $id)->get();
        $clientes = \App\Models\Cliente::where('company_id', $id)->get();
        $awards = \App\Models\Award::where('company_id', $id)->get();

        $company = $this->company->findOrFail($id);
        $partners = $company->partners()->get();

        return view(
            'admin.companies.show',
            compact('company', 'partners', 'partner_types', 'orders', 'clientes', 'awards')
        );
    }


    /**
     * Remove Company from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('company_delete')) {
            return abort(401);
        }
        $company = $this->company->findOrFail($id);
        $company->delete();

        return redirect()->route('admin.companies.index');
    }

    /**
     * Delete all selected Company at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('company_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = $this->company->whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Company from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('company_delete')) {
            return abort(401);
        }
        $company = $this->company->onlyTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->route('admin.companies.index');
    }

    /**
     * Permanently delete Company from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('company_delete')) {
            return abort(401);
        }
        $company = $this->company->onlyTrashed()->findOrFail($id);
        $company->forceDelete();

        return redirect()->route('admin.companies.index');
    }
}
