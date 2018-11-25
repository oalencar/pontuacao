<?php

namespace App\Http\Controllers\Admin;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientesRequest;
use App\Http\Requests\Admin\UpdateClientesRequest;

class ClientesController extends Controller
{
    /**
     * Display a listing of Cliente.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('cliente_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('cliente_delete')) {
                return abort(401);
            }
            $clientes = Cliente::onlyTrashed()->get();
        } else {
            $clientes = Cliente::all();
        }

        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating new Cliente.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('cliente_create')) {
            return abort(401);
        }
        
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.clientes.create', compact('companies'));
    }

    /**
     * Store a newly created Cliente in storage.
     *
     * @param  \App\Http\Requests\StoreClientesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientesRequest $request)
    {
        if (! Gate::allows('cliente_create')) {
            return abort(401);
        }
        $cliente = Cliente::create($request->all());



        return redirect()->route('admin.clientes.index');
    }


    /**
     * Show the form for editing Cliente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('cliente_edit')) {
            return abort(401);
        }
        
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $cliente = Cliente::findOrFail($id);

        return view('admin.clientes.edit', compact('cliente', 'companies'));
    }

    /**
     * Update Cliente in storage.
     *
     * @param  \App\Http\Requests\UpdateClientesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientesRequest $request, $id)
    {
        if (! Gate::allows('cliente_edit')) {
            return abort(401);
        }
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());



        return redirect()->route('admin.clientes.index');
    }


    /**
     * Display Cliente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('cliente_view')) {
            return abort(401);
        }
        
        $companies = \App\Company::get()->pluck('nome', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$orders = \App\Order::where('client_id', $id)->get();

        $cliente = Cliente::findOrFail($id);

        return view('admin.clientes.show', compact('cliente', 'orders'));
    }


    /**
     * Remove Cliente from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('cliente_delete')) {
            return abort(401);
        }
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('admin.clientes.index');
    }

    /**
     * Delete all selected Cliente at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('cliente_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Cliente::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Cliente from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('cliente_delete')) {
            return abort(401);
        }
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('admin.clientes.index');
    }

    /**
     * Permanently delete Cliente from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('cliente_delete')) {
            return abort(401);
        }
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->forceDelete();

        return redirect()->route('admin.clientes.index');
    }
}
