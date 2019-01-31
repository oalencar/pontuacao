<?php

namespace App\Services;

use App\Company;

class CompanyService
{

    /**
     * CompanyService constructor.
     * @param Company $company
     */
    public function __construct(
        Company $company
    ) {
        $this->company = $company;
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
}
