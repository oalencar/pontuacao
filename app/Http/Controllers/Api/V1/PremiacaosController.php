<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Award;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAwardsRequest;
use App\Http\Requests\Admin\UpdateAwardsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class AwardsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Award::all();
    }

    public function show($id)
    {
        return Award::findOrFail($id);
    }

    public function update(UpdateAwardsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $award = Award::findOrFail($id);
        $award->update($request->all());


        return $award;
    }

    public function store(StoreAwardsRequest $request)
    {
        $request = $this->saveFiles($request);
        $award = Award::create($request->all());


        return $award;
    }

    public function destroy($id)
    {
        $award = Award::findOrFail($id);
        $award->delete();
        return '';
    }
}
