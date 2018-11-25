<?php

namespace App\Http\Controllers\Admin;

use App\Premiacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePremiacaosRequest;
use App\Http\Requests\Admin\UpdatePremiacaosRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class PremiacaosController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Premiacao.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('premiacao_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('premiacao_delete')) {
                return abort(401);
            }
            $premiacaos = Premiacao::onlyTrashed()->get();
        } else {
            $premiacaos = Premiacao::all();
        }

        return view('admin.premiacaos.index', compact('premiacaos'));
    }

    /**
     * Show the form for creating new Premiacao.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('premiacao_create')) {
            return abort(401);
        }
        
        $partner_types = \App\PartnerType::get()->pluck('description', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.premiacaos.create', compact('partner_types', 'companies'));
    }

    /**
     * Store a newly created Premiacao in storage.
     *
     * @param  \App\Http\Requests\StorePremiacaosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePremiacaosRequest $request)
    {
        if (! Gate::allows('premiacao_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $premiacao = Premiacao::create($request->all());



        return redirect()->route('admin.premiacaos.index');
    }


    /**
     * Show the form for editing Premiacao.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('premiacao_edit')) {
            return abort(401);
        }
        
        $partner_types = \App\PartnerType::get()->pluck('description', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $premiacao = Premiacao::findOrFail($id);

        return view('admin.premiacaos.edit', compact('premiacao', 'partner_types', 'companies'));
    }

    /**
     * Update Premiacao in storage.
     *
     * @param  \App\Http\Requests\UpdatePremiacaosRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePremiacaosRequest $request, $id)
    {
        if (! Gate::allows('premiacao_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $premiacao = Premiacao::findOrFail($id);
        $premiacao->update($request->all());



        return redirect()->route('admin.premiacaos.index');
    }


    /**
     * Display Premiacao.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('premiacao_view')) {
            return abort(401);
        }
        $premiacao = Premiacao::findOrFail($id);

        return view('admin.premiacaos.show', compact('premiacao'));
    }


    /**
     * Remove Premiacao from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('premiacao_delete')) {
            return abort(401);
        }
        $premiacao = Premiacao::findOrFail($id);
        $premiacao->delete();

        return redirect()->route('admin.premiacaos.index');
    }

    /**
     * Delete all selected Premiacao at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('premiacao_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Premiacao::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Premiacao from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('premiacao_delete')) {
            return abort(401);
        }
        $premiacao = Premiacao::onlyTrashed()->findOrFail($id);
        $premiacao->restore();

        return redirect()->route('admin.premiacaos.index');
    }

    /**
     * Permanently delete Premiacao from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('premiacao_delete')) {
            return abort(401);
        }
        $premiacao = Premiacao::onlyTrashed()->findOrFail($id);
        $premiacao->forceDelete();

        return redirect()->route('admin.premiacaos.index');
    }
}
