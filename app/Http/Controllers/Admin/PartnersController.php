<?php

namespace App\Http\Controllers\Admin;

use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnersRequest;
use App\Http\Requests\Admin\UpdatePartnersRequest;

class PartnersController extends Controller
{
    private $partner;
    /**
     * PartnersController constructor.
     */
    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
    }

    /**
     * Display a listing of Partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('partner_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('partner_delete')) {
                return abort(401);
            }
            $partners = $this->partner::onlyTrashed()->get();
        } else {
            $partners = $this->partner::all();
        }

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating new Partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('partner_create')) {
            return abort(401);
        }

        $companies = \App\Company::get();
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $partner_types = \App\PartnerType::get()->pluck('description', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.partners.create', compact('companies', 'users', 'partner_types'));
    }

    /**
     * Store a newly created Partner in storage.
     *
     * @param  \App\Http\Requests\StorePartnersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartnersRequest $request)
    {
        if (! Gate::allows('partner_create')) {
            return abort(401);
        }
        $partner = $this->partner::create($request->except('company_id'));
        $partner->companies()->sync($request->get('company_id'));

        return redirect()->route('admin.partners.index');
    }


    /**
     * Show the form for editing Partner.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('partner_edit')) {
            return abort(401);
        }

        $companies = \App\Company::get()->pluck('nome', 'id');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $partner_types = \App\PartnerType::get()->pluck('description', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $partner = $this->partner::findOrFail($id);
        $partnerCompanies = $partner->companies()->get();

        return view('admin.partners.edit', compact('partner', 'companies', 'users', 'partner_types', 'partnerCompanies'));
    }

    /**
     * Update Partner in storage.
     *
     * @param  \App\Http\Requests\UpdatePartnersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartnersRequest $request, $id)
    {
        if (! Gate::allows('partner_edit')) {
            return abort(401);
        }

        $partner = $this->partner::findOrFail($id);

        $partner->update($request->except('company_id'));
        $partner->companies()->sync($request->get('company_id'));

        return redirect()->route('admin.partners.index');
    }


    /**
     * Display Partner.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('partner_view')) {
            return abort(401);
        }
        $partner = $this->partner::findOrFail($id);

        return view('admin.partners.show', compact('partner'));
    }


    /**
     * Remove Partner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        $partner = $this->partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index');
    }

    /**
     * Delete all selected Partner at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = $this->partner::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Partner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        $partner = $this->partner::onlyTrashed()->findOrFail($id);
        $partner->restore();

        return redirect()->route('admin.partners.index');
    }

    /**
     * Permanently delete Partner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        $partner = $this->partner::onlyTrashed()->findOrFail($id);
        $partner->forceDelete();

        return redirect()->route('admin.partners.index');
    }
}
