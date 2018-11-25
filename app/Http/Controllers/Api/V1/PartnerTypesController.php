<?php

namespace App\Http\Controllers\Api\V1;

use App\PartnerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnerTypesRequest;
use App\Http\Requests\Admin\UpdatePartnerTypesRequest;

class PartnerTypesController extends Controller
{
    public function index()
    {
        return PartnerType::all();
    }

    public function show($id)
    {
        return PartnerType::findOrFail($id);
    }

    public function update(UpdatePartnerTypesRequest $request, $id)
    {
        $partner_type = PartnerType::findOrFail($id);
        $partner_type->update($request->all());
        
        $premiacaos           = $partner_type->premiacaos;
        $currentPremiacaoData = [];
        foreach ($request->input('premiacaos', []) as $index => $data) {
            if (is_integer($index)) {
                $partner_type->premiacaos()->create($data);
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

        return $partner_type;
    }

    public function store(StorePartnerTypesRequest $request)
    {
        $partner_type = PartnerType::create($request->all());
        
        foreach ($request->input('premiacaos', []) as $data) {
            $partner_type->premiacaos()->create($data);
        }

        return $partner_type;
    }

    public function destroy($id)
    {
        $partner_type = PartnerType::findOrFail($id);
        $partner_type->delete();
        return '';
    }
}
