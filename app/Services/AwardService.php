<?php

namespace App\Services;


use App\Award;
use App\Partner;
use App\Models\PartnerType;
use App\Models\Company;

/**
 * Class AwardService
 * @package App\Services
 */
class AwardService
{
    /**
     * @var PartnerType
     */
    private $partner_type;
    /**
     * @var Company
     */
    private $company;

    /**
     * @var Partner
     */
    private $partner;

    /**
     * AwardService constructor.
     * @param Company $company
     * @param PartnerType $partner_type
     * @param Partner $partner
     */
    public function __construct(Company $company, PartnerType $partner_type, Partner $partner)
    {
        $this->company = $company;
        $this->partner_type = $partner_type;
        $this->partner = $partner;
    }

    /**
     * @param $partner Partner
     * @return Awards
     */
    public function getPartnerAwards($partner) {
        $awards = $partner->partner_type->awards;
        return $awards;
    }
}
