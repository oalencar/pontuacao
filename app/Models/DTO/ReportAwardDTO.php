<?php
/**
 * Created by PhpStorm.
 * User: oscaralencar
 * Date: 2019-04-15
 * Time: 21:19
 */

namespace App\Models\DTO;


use App\Models\Partner;
use App\Services\ScoreService;
use App\User;
use Illuminate\Support\Collection;

class ReportAwardDTO
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var Partner[]
     */
    private $partners;


    /**
     * @return int
     */
    public function getTotal(): int
    {
        $partners = $this->getPartners();
        $award = $this->getAward();

        $soma = $partners->map(function($partner) use ($award) {
            return $this->scoreService->sumOfScores($this->scoreService->filterPartnerScoresOfAward($partner->scores, $award));
        });

        return $soma->sum();
    }

    private $scoreService;

    private $award;

    /**
     * @return mixed
     */
    public function getAward()
    {
        return $this->award;
    }

    /**
     * @param mixed $award
     */
    public function setAward($award): void
    {
        $this->award = $award;
    }


    /**
     * ReportAwardDTO constructor.
     * @param $user User
     * @param $partners Partner[]
     */
    public function __construct($user, $partners, $award)
    {
        $this->setUser($user);
        $this->setPartners($partners);
        $this->setAward($award);
        $this->scoreService = app()->make(ScoreService::class);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Partner[]|Collection
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    /**
     * @param Partner[]|Collection $partners
     */
    public function setPartners(Collection $partners): void
    {
        $this->partners = $partners;
    }
}
