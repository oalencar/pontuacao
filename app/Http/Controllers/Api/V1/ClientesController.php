<?php

namespace App\Http\Controllers\Api\V1;

use App\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientesRequest;
use App\Http\Requests\Admin\UpdateClientesRequest;

class ClientesController extends Controller
{
    /**
     * @var Cliente
     */
    private $client;

    public function __construct(Cliente $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        return $this->client::all();
    }

    public function show($id)
    {
        return $this->client::findOrFail($id);
    }

    public function update(UpdateClientesRequest $request, $id)
    {
        $cliente = $this->client::findOrFail($id);
        $cliente->update($request->all());


        return $cliente;
    }

    public function store(StoreClientesRequest $request)
    {
        $cliente = $this->client::create($request->all());


        return $cliente;
    }

    public function destroy($id)
    {
        $cliente = $this->client::findOrFail($id);
        $cliente->delete();
        return '';
    }

    /**
     * @return string
     */
    public function clientsFromCompany(int $companyId) : array
    {
        return $this->client::where('company_id', $companyId)->get()->toArray();
    }
}
