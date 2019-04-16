<?php


namespace App\Services;


use App\Partner;
use App\PartnerType;

class PartnerTypeService
{

    private $partner_type;
    private $partner;

    /**
     * PartnerTypeService constructor.
     * @param PartnerType $partner_type
     * @param Partner $partner
     */
    public function __construct(
        PartnerType $partner_type,
        Partner $partner
    ) {
        $this->partner_type = $partner_type;
        $this->partner = $partner;
    }

    /**
     * @param $partner_type PartnerType
     * @return Partner[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllPartners($partner_type)
    {
        return $this->partner::where('partner_type_id', $partner_type->id)->get();
    }

}
