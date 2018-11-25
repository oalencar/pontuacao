<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompaniesRequest;
use App\Http\Requests\Admin\UpdateCompaniesRequest;

class CompaniesController extends Controller
{
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
            $companies = Company::onlyTrashed()->get();
        } else {
            $companies = Company::all();
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
        $company = Company::create($request->all());

        foreach ($request->input('premiacaos', []) as $data) {
            $company->premiacaos()->create($data);
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
        $company = Company::findOrFail($id);

        return view('admin.companies.edit', compact('company'));
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
        $company = Company::findOrFail($id);
        $company->update($request->all());

        $premiacaos           = $company->premiacaos;
        $currentPremiacaoData = [];
        foreach ($request->input('premiacaos', []) as $index => $data) {
            if (is_integer($index)) {
                $company->premiacaos()->create($data);
            } else {
                $id                          = explode('-', $index)[1];
                $currentPremiacaoData[$id] = $data;
            }
        }
        foreach ($premiacaos as $item) {
            if (isset($currentPremiacaoData[$item->id])) {
                $item->update($currentPremiacaoData[$item->id]);
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
        $partners = \App\Partner::where('company_id', $id)->get();$partner_types = \App\PartnerType::where('company_id', $id)->get();$orders = \App\Order::where('company_id', $id)->get();$clientes = \App\Cliente::where('company_id', $id)->get();$premiacaos = \App\Premiacao::where('company_id', $id)->get();

        $company = Company::findOrFail($id);

        return view('admin.companies.show', compact('company', 'partners', 'partner_types', 'orders', 'clientes', 'premiacaos'));
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
        $company = Company::findOrFail($id);
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
            $entries = Company::whereIn('id', $request->input('ids'))->get();

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
        $company = Company::onlyTrashed()->findOrFail($id);
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
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->forceDelete();

        return redirect()->route('admin.companies.index');
    }
}
