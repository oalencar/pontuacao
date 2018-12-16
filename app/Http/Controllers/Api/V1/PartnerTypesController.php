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

        return $partner_type;
    }

    public function store(StorePartnerTypesRequest $request)
    {
        $partner_type = PartnerType::create($request->all());

        foreach ($request->input('awards', []) as $data) {
            $partner_type->awards()->create($data);
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
