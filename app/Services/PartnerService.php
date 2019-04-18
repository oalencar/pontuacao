<?php
/**
 * Created by PhpStorm.
 * User: oscaralencar
 * Date: 2019-03-09
 * Time: 10:18
 */

namespace App\Services;


use App\Models\Partner;
use App\Models\Score;

class PartnerService
{
    private $partner;
    private $score;

    /**
     * PartnerService constructor.
     * @param Partner $partner
     * @param Score $score
     */
    public function __construct(Partner $partner, Score $score)
    {
        $this->partner = $partner;
        $this->score = $score;
    }

    /**
     * @param $partner Partner
     * @return Score[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPartnerScores($partner)
    {
        return $this->score::where('partner_id', $partner->id)->get();
    }

    /**
     * @param $partner Partner
     */
    public function deleteAllPartnerScores($partner)
    {
        $scores = $this->getPartnerScores($partner);
        $scores->each(function ($score) {
            $score->delete();
        });
    }


}
