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

    public function findByCompany($company_id) {
        return $company_id;
    }


}
