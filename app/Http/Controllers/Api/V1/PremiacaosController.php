<?php

namespace App\Http\Controllers\Api\V1;

use App\Premiacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePremiacaosRequest;
use App\Http\Requests\Admin\UpdatePremiacaosRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class PremiacaosController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Premiacao::all();
    }

    public function show($id)
    {
        return Premiacao::findOrFail($id);
    }

    public function update(UpdatePremiacaosRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $premiacao = Premiacao::findOrFail($id);
        $premiacao->update($request->all());
        

        return $premiacao;
    }

    public function store(StorePremiacaosRequest $request)
    {
        $request = $this->saveFiles($request);
        $premiacao = Premiacao::create($request->all());
        

        return $premiacao;
    }

    public function destroy($id)
    {
        $premiacao = Premiacao::findOrFail($id);
        $premiacao->delete();
        return '';
    }
}
