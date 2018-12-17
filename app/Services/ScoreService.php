<?php

namespace App\Services;

use App\Award;
use App\Partner;
use App\Score;
use Carbon\Carbon;

class ScoreService
{
    /**
     * ScoreService constructor.
     */
    public function __construct(
        Partner $partner,
        Score $score
    ) {
        $this->partner = $partner;
        $this->score = $score;
    }

    /**
     * Return All Scores From A Partner
     *
     * @param Partner
     * @return array Score
     */
    public function getAllScoresFromPartner($partner) {
        if (!$partner) {
            abort(500, 'Necessário passar Parceiro para getAllScoresFromPartner');
        }
        return $this->score::where('user_id', $partner->user_id)->get();
    }

    /**
     * @param $scores array Score
     * @param $award Award
     * @return array Score
     */
    public function filterPartnerScoresOfAward($scores, $award){
        if (!$award) {
            abort(500, 'Necessário passar Parceiro para filterScoresOfAward');
        }

        return $scores->filter(function($item, $key) use ($award) {

            $orderStartDate = Carbon::createFromFormat(config('app.date_format'), $item->order->start_date);
            $awardStartDate = Carbon::createFromFormat(config('app.date_format'), $award->start_date);
            $awardFinishDate = Carbon::createFromFormat(config('app.date_format'), $award->finish_date);

            return $orderStartDate->between($awardStartDate, $awardFinishDate);
        });
    }

    /**
     * @param $scores array Score
     * @return int
     */
    public function sumOfScores($scores) {
        if (!$scores) {
            abort(500, 'Necessário passar score para sumOfScores');
        }
        return $scores->sum('score');
    }
}
