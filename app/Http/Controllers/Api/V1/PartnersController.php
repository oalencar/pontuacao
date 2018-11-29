<?php

namespace App\Http\Controllers\Api\V1;

use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    public function index()
    {
        return Partner::all();
    }

    public function show($id)
    {
        return Partner::findOrFail($id);
    }

    public function findByCompany($id) {
        $company_id = $id;

        if (!$company_id) {
            abort(400, 'bad request.');
        }

        $partners =  Partner::with('user')->where('company_id', $company_id)->get();

        return collect($partners)->map(function($item) {
           return $item->user;
        });

    }


}
