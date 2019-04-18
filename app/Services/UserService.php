<?php


namespace App\Services;


use App\Partner;
use App\User;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{

    /**
     * @var User
     */
    private $user;
    /**
     * @var PartnerService
     */
    private $partnerService;

    /**
     * @var Partner
     */
    private $partner;

    /**
     * UserService constructor.
     * @param User $user
     * @param PartnerService $partnerService
     * @param Partner $partner
     */
    public function __construct(User $user, PartnerService $partnerService, Partner $partner)
    {
        $this->user = $user;
        $this->partnerService = $partnerService;
        $this->partner = $partner;
    }

    /**
     * @param User $user
     */
    public function removeUserPartnersAndAllYourScores($user)
    {
        $partners = $this->partner->where('user_id', $user->id)->get();

        $partners->each(function($partner){
            $this->partnerService->deleteAllPartnerScores($partner);
            $partner->delete();
        });


    }

}
