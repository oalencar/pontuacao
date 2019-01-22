<?php

namespace App\Http\Controllers\Admin;

use App\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAwardsRequest;
use App\Http\Requests\Admin\UpdateAwardsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class AwardsController extends Controller
{
    public function __construct(Award $award)
    {
        $this->award = $award;
    }

    use FileUploadTrait;

    /**
     * Display a listing of Award.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('award_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('award_delete')) {
                return abort(401);
            }
            $awards = $this->award->onlyTrashed()->get();
        } else {
            $awards = $this->award->all();
        }

        return view('admin.awards.index', compact('awards'));
    }

    /**
     * Show the form for creating new Award.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('award_create')) {
            return abort(401);
        }

        $partner_types = \App\PartnerType::get();
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.awards.create', compact('partner_types', 'companies'));
    }

    /**
     * Store a newly created Award in storage.
     *
     * @param  \App\Http\Requests\StoreAwardsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAwardsRequest $request)
    {
        if (! Gate::allows('award_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);

        $award = $this->award->create($request->except(['partner_type_id']));
        $award->partner_types()->sync($request->get('partner_type_id'));

        return redirect()->route('admin.awards.index');
    }


    /**
     * Show the form for editing Award.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('award_edit')) {
            return abort(401);
        }

        $partner_types = \App\PartnerType::get()->pluck('description', 'id');
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $award = $this->award->findOrFail($id);
        $partnerTypesArwards = $award->partner_types()->get();

        return view(
            'admin.awards.edit',
            compact(
            'award',
            'partner_types',
            'partnerTypesArwards',
            'companies'));
    }

    /**
     * Update Award in storage.
     *
     * @param  \App\Http\Requests\UpdateAwardsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAwardsRequest $request, $id)
    {
        if (! Gate::allows('award_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $award = $this->award->findOrFail($id);
        $award->update($request->except(['partner_type_id']));
        $award->partner_types()->sync($request->get('partner_type_id'));

        return redirect()->route('admin.awards.index');
    }


    /**
     * Display Award.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('award_view')) {
            return abort(401);
        }
        $award = $this->award->findOrFail($id);

        return view('admin.awards.show', compact('award'));
    }


    /**
     * Remove Award from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('award_delete')) {
            return abort(401);
        }
        $award = $this->award->findOrFail($id);
        $award->delete();

        return redirect()->route('admin.awards.index');
    }

    /**
     * Delete all selected Award at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('award_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = $this->award->whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Award from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('award_delete')) {
            return abort(401);
        }
        $award = $this->award->onlyTrashed()->findOrFail($id);
        $award->restore();

        return redirect()->route('admin.awards.index');
    }

    /**
     * Permanently delete Award from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('award_delete')) {
            return abort(401);
        }
        $award = $this->award->onlyTrashed()->findOrFail($id);
        $award->forceDelete();

        return redirect()->route('admin.awards.index');
    }
}
