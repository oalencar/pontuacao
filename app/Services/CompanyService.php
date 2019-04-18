<?php

namespace App\Services;

use App\Award;
use App\Models\Company;
use App\Models\PartnerType;

class CompanyService
{
    private $company;
    private $partner_type;
    private $award;

    /**
     * CompanyService constructor.
     * @param Company $company
     */
    public function __construct(
        Company $company,
        PartnerType $partner_type,
        Award $award
    ) {
        $this->company = $company;
        $this->partner_type = $partner_type;
        $this->award = $award;
    }


    /**
     * @param $id
     * @return Company | null
     */
    public function getCompany($id) {
        if (!$id) {
            return null;
        }
        return $this->company->find($id);
    }

    /**
     * @param $company Company
     * @return Award[]|[]
     */
    public function getAwards($company) {
        $awards = $this->award::with('partner_types')->get();

        return $awards->filter(function ($item) use ($company) {
            return $item->partner_types->contains('company_id', $company->id);
        });
    }

}
