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

        $allPartners =  Partner::with('user', 'companies')->get();

        $partners = $allPartners->filter(function ($partner) use ($company_id) {
            $companies = collect($partner->companies);
            return $companies->contains(function ($company) use ($company_id) {
                return $company->id == $company_id;
            } );
        });


        return collect($partners)->map(function($item) {
           return $item->user;
        });

    }


}
