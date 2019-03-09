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

    public function findByCompany($id)
    {
        $company_id = $id;

        if (!$company_id) {
            abort(400, 'bad request.');
        }

        $allPartners = $this->partner::with('user', 'company', 'partner_type')->get();

        return $this->partner::with('user', 'company', 'partner_type')
                                ->where('company_id', $company_id)->get()->toArray();
    }


}
