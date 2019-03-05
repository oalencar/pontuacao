<?php

namespace App\Http\Controllers\Api\V1;

use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    /**
     * @var Partner
     */
    private $partner;

    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
    }

    public function index()
    {
        return $this->partner::all();
    }

    public function show($id)
    {
        return $this->partner::findOrFail($id);
    }

    public function findByCompany($id) {
        $company_id = $id;

        if (!$company_id) {
            abort(400, 'bad request.');
        }

        $allPartners =  $this->partner::with('user', 'companies', 'partner_type')->get();

        return $partners = $allPartners->filter(function ($partner) use ($company_id) {
            $companies = collect($partner->companies);
            return $companies->contains(function ($company) use ($company_id) {
                return $company->id == $company_id;
            } );
        });

    }


}
