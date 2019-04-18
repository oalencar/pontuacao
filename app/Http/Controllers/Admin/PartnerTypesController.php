<?php

namespace App\Http\Controllers\Admin;

use App\Models\PartnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnerTypesRequest;
use App\Http\Requests\Admin\UpdatePartnerTypesRequest;

class PartnerTypesController extends Controller
{
    /**
     * Display a listing of PartnerType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('partner_type_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('partner_type_delete')) {
                return abort(401);
            }
            $partner_types = PartnerType::onlyTrashed()->get();
        } else {
            $partner_types = PartnerType::all();
        }

        return view('admin.partner_types.index', compact('partner_types'));
    }

    /**
     * Show the form for creating new PartnerType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('partner_type_create')) {
            return abort(401);
        }

        $companies = \App\Models\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.partner_types.create', compact('companies'));
    }

    /**
     * Store a newly created PartnerType in storage.
     *
     * @param  \App\Http\Requests\StorePartnerTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartnerTypesRequest $request)
    {
        if (! Gate::allows('partner_type_create')) {
            return abort(401);
        }
        $partner_type = PartnerType::create($request->all());

        foreach ($request->input('awards', []) as $data) {
            $partner_type->awards()->create($data);
        }


        return redirect()->route('admin.partner_types.index');
    }


    /**
     * Show the form for editing PartnerType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('partner_type_edit')) {
            return abort(401);
        }

        $companies = \App\Models\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $partner_type = PartnerType::findOrFail($id);

        return view('admin.partner_types.edit', compact('partner_type', 'companies'));
    }

    /**
     * Update PartnerType in storage.
     *
     * @param  \App\Http\Requests\UpdatePartnerTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartnerTypesRequest $request, $id)
    {
        if (! Gate::allows('partner_type_edit')) {
            return abort(401);
        }
        $partner_type = PartnerType::findOrFail($id);
        $partner_type->update($request->all());

        $awards           = $partner_type->awards;
        $currentAwardData = [];
        foreach ($request->input('awards', []) as $index => $data) {
            if (is_integer($index)) {
                $partner_type->awards()->create($data);
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


        return redirect()->route('admin.partner_types.index');
    }


    /**
     * Display PartnerType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('partner_type_view')) {
            return abort(401);
        }

        $companies = \App\Models\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$partners = \App\Models\Partner::where('partner_type_id', $id)->get();$awards = \App\Models\Award::where('partner_type_id', $id)->get();

        $partner_type = PartnerType::findOrFail($id);

        return view('admin.partner_types.show', compact('partner_type', 'partners', 'awards'));
    }


    /**
     * Remove PartnerType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('partner_type_delete')) {
            return abort(401);
        }
        $partner_type = PartnerType::findOrFail($id);
        $partner_type->delete();

        return redirect()->route('admin.partner_types.index');
    }

    /**
     * Delete all selected PartnerType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('partner_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = PartnerType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore PartnerType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('partner_type_delete')) {
            return abort(401);
        }
        $partner_type = PartnerType::onlyTrashed()->findOrFail($id);
        $partner_type->restore();

        return redirect()->route('admin.partner_types.index');
    }

    /**
     * Permanently delete PartnerType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('partner_type_delete')) {
            return abort(401);
        }
        $partner_type = PartnerType::onlyTrashed()->findOrFail($id);
        $partner_type->forceDelete();

        return redirect()->route('admin.partner_types.index');
    }
}
