<?php

namespace App\Http\Controllers\Api\V1;

use App\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientesRequest;
use App\Http\Requests\Admin\UpdateClientesRequest;

class ClientesController extends Controller
{
    public function index()
    {
        return Cliente::all();
    }

    public function show($id)
    {
        return Cliente::findOrFail($id);
    }

    public function update(UpdateClientesRequest $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        

        return $cliente;
    }

    public function store(StoreClientesRequest $request)
    {
        $cliente = Cliente::create($request->all());
        

        return $cliente;
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return '';
    }
}
